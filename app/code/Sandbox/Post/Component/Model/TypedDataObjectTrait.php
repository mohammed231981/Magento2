<?php declare(strict_types = 1);

namespace Sandbox\Post\Component\Model;

use Magento\Framework\DataObject;
use Magento\Framework\Model\AbstractModel;

/**
 * Trait ModelDataTrait
 */
trait TypedDataObjectTrait
{
    /**
     * @var string[]|null
     */
    private $columnDataTypes;

    /**
     * @var \Magento\Framework\DataObject|null
     */
    private $dataObject;

    /**
     * @param \Magento\Framework\DataObject $dataObject
     * @param string[]                      $columnDataTypes
     * @return void
     */
    public function initDataTypedModel(DataObject $dataObject, array $columnDataTypes): void
    {
        $this->dataObject = $dataObject;
        $this->columnDataTypes = $columnDataTypes;
    }

    /**
     * @param string     $columnName
     * @param mixed|null $default
     * @return bool|float|int|string|null
     */
    public function getColumn(string $columnName, $default = null)
    {
        return $this->getDataTyped($this->dataObject, $columnName, $this->columnDataTypes[$columnName], $default);
    }

    /**
     * @param string $columnName
     * @param mixed  $value
     * @param bool nullable
     * @SuppressWarnings(PHPMD.BooleanArgumentFlag)
     * @return void
     */
    public function setColumn(string $columnName, $value, $nullable = true): void
    {
        if (null === $value && false === $nullable) {
            throw new \InvalidArgumentException(
                sprintf(
                    'Column %s is not nullable',
                    $columnName
                )
            );
        }

        $this->dataObject->setData(
            $columnName,
            null === $value
                ? $value
                : $this->makeTyped($this->columnDataTypes[$columnName], $value)
        );
    }

    /**
     * @param \Magento\Framework\DataObject $model
     * @param string                        $key
     * @param string                        $dataType
     * @param null                          $default
     * @return bool|float|int|string|null
     */
    private function getDataTyped(DataObject $model, string $key, string $dataType, $default = null)
    {
        if (!$model->hasData($key) || null === $model->getData($key)) {
            return $default;
        }

        $value = $model->getData($key);

        return $this->makeTyped($dataType, $value);
    }

    /**
     * @param string $dataType
     * @param mixed  $value
     * @return bool|float|int|string
     */
    private function makeTyped(string $dataType, $value)
    {
        if ('int' === $dataType) {
            return (int)$value;
        }

        if ('string' === $dataType) {
            return (string)$value;
        }

        if ('bool' === $dataType) {
            return (bool)$value;
        }

        if ('float' === $dataType) {
            return (float)$value;
        }

        throw new \InvalidArgumentException(sprintf('Unknown data type %s', $dataType));
    }

    /**
     * @param \Magento\Framework\Model\AbstractModel $model
     * @return int|null
     */
    public function getIdTyped(AbstractModel $model): ?int
    {
        return $this->getDataTyped($model, $model->getIdFieldName(), 'int');
    }

    /**
     * @param \Magento\Framework\DataObject $model
     * @param string                        $key
     * @param int|null                      $default
     * @return int|null
     */
    public function getDataInt(DataObject $model, string $key, ?int $default = null): ?int
    {
        return $this->getDataTyped($model, $key, 'int', $default);
    }

    /**
     * @param \Magento\Framework\DataObject $model
     * @param string                        $key
     * @param string|null                   $default
     * @return string|null
     */
    public function getDataString(DataObject $model, string $key, ?string $default = null): ?string
    {
        return $this->getDataTyped($model, $key, 'string', $default);
    }

    /**
     * @param \Magento\Framework\DataObject $model
     * @param string                        $key
     * @param bool|null                     $default
     * @return bool|null
     */
    public function getDataBool(DataObject $model, string $key, ?bool $default = null): ?bool
    {
        return $this->getDataTyped($model, $key, 'bool', $default);
    }

    /**
     * @param \Magento\Framework\DataObject $model
     * @param string                        $key
     * @param float|null                    $default
     * @return float|null
     */
    public function getDataFloat(DataObject $model, string $key, ?float $default = null): ?float
    {
        return $this->getDataTyped($model, $key, 'float', $default);
    }
}
