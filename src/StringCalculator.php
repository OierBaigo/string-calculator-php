<?php

namespace Deg540\StringCalculatorPHP;

use Exception;

class StringCalculator
{
    /**
     * @param string $numbers
     * @return int|string
     */
    function add(string $numbers): int|string {
        try {
            if(empty($numbers))  return 0;
            if($this->isOneNumber($numbers))  return $numbers;
            [$delimiter,$numbers] = $this->getDelimiterNumbers($numbers);
            $separatedNumbers = $this->getSeparatedNumbers($numbers,$delimiter);
            if($this->checkAllPositiveNumbers($separatedNumbers)) return $this->sumSeparatedNumbers($separatedNumbers);
            throw new Exception($this->manageException($separatedNumbers));
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * @return string[]
     */
    private function getSeparatedNumbers(string $numbers, string $delimiter): array
    {
        $escapedDelimiter = preg_quote($delimiter, '/');
        return preg_split('/[\n ' . $escapedDelimiter . ' ]+/', $numbers);
    }

    /**
     * @param array $separatedNumbers
     * @return int
     */
    private function sumSeparatedNumbers(array $separatedNumbers): int
    {
        $sum = 0;
        foreach ($separatedNumbers as $number) {
            $sum += intval($number);
        }
        return $sum;
    }

    /**
     * @param string $numbers
     * @return bool
     */
    private function isOneNumber(string $numbers): bool
    {
        return strlen($numbers) < 2;
    }

    /**
     * @param string $numbers
     * @return array
     */
    private function getDelimiterNumbers(string $numbers): array
    {
        if($numbers[0] == "/"){
            return [$this->getDelimiter($numbers), $this->getNumbers($numbers)];

        }
        return [",",$numbers];
    }

    /**
     * @param string $numbers
     * @return string
     */
    private function getDelimiter(string $numbers): string
    {
        return substr(explode("\n", $numbers, 2)[0], 2);
    }

    /**
     * @param string $numbers
     * @return string
     */
    private function getNumbers(string $numbers): string
    {
        return explode("\n", $numbers, 2)[1];
    }

    private function checkAllPositiveNumbers(array $separatedNumbers): bool
    {
        foreach ($separatedNumbers as $number) {
            if(intval($number) < 0) return false;
        }
        return true;
    }

    private function manageException(array $separatedNumbers): string
    {
        $exception = "negativos no soportados:";
        foreach ($separatedNumbers as $number) {
            if(intval($number) < 0) $exception .= ' ' . $number;
        }
        return $exception;
    }
}