<?php declare(strict_types=1);

namespace Myronenkod\TestProject\Retrivers;

use Myronenkod\TestProject\Data\CurrencyCodes;
use Myronenkod\TestProject\Exceptions\DataFormatException;
use Myronenkod\TestProject\Exceptions\FileOpenExceptions;
use Myronenkod\TestProject\Exceptions\JsonDecodeException;
use Myronenkod\TestProject\ValueObjects\TransactionInfo;

class ConcreteDataRetriver implements DataRetriverInterface
{
    /**
     * @var resource
     */
    private $fileDescriptor;

    private ?TransactionInfo $value = null;

    public function __construct(private string $filename)
    {
        $this->getFileDescriptor();
        $this->next();
    }

    public function current(): TransactionInfo {
        return $this->value;
    }

    public function next(): void {
        if (feof($this->fileDescriptor)) {
            $this->value = null;
            return;
        }

        $data = $this->decodeAndValidate(fgets($this->fileDescriptor));

        $this->value = $data === []
            ? null
            : new TransactionInfo($data['bin'], $data['amount'], $data['currency']);
    }

    public function valid(): bool {
        return $this->value !== null;
    }
    public function decodeAndValidate(string $data): array {
        $data = json_decode($data, true);

        if ($data === null) {
            throw new JsonDecodeException("Can't decode file data {$this->filename}");
        }
        $errors = [];
        if (is_numeric($data['bin']) === false) {
            $errors[] = "bin";
        }

        $data['bin'] = (int) $data['bin'];

        if (is_numeric($data['amount']) === false) {
            $errors[] = "amount";
        }

        $data['amount'] = (int) $data['amount'];

        if (CurrencyCodes::check($data['currency']) === false) {
            $errors[] = "currency";
        }

        if ($errors !== []) {
            throw new DataFormatException("Failed fields validation: [" . join(", ", $errors) . "]");
        }

        return $data;
    }

    public function key(): mixed
    {
        return $this->value->getBin();
    }

    public function rewind(): void {
        fseek($this->getFileDescriptor(), 0);
    }

    /**
     * @param string $filename
     * @return resource
     * @throws FileOpenExceptions
     */
    private function getFileDescriptor()
    {
        if ($this->fileDescriptor === null) {
            $this->fileDescriptor = fopen($this->filename, 'r');
            if ($this->fileDescriptor === false) {
                throw new FileOpenExceptions("Can't open file {$this->filename}");
            }
        }

        return $this->fileDescriptor;
    }
}