<?php

/**
 * This class requires PHP 7.4 since property is typed
 */
class FizzBuzz
{

    /// Array of divisors allowing to add a new one easily/
    /// We could also add accessors to allow changes from code but it would require discussing rules.
    /// For now order is manual to allow FizzBuzz on 15
    private array $divisors = [
        3 => 'Fizz',
        5 => 'Buzz',
    ];

    /// There is no rule about a separator but it's not lisible without it.
    /// We could also add getter - setter but it's not required for now so we avoid unnecessary code.
    private string $separator = ' - ';

    /**
     * @param int $length Cannot be less than 1
     *
     * @return string
     */
    public function replaceNumbers(int $length): string
    {
        /// First step we check the parameter
        if ($length < 1) {
            throw new InvalidArgumentException('Length cannot be less than 1');
        }

        $result = [];
        for ($i = 1; $i <= $length; ++$i) {
            $result[] = $this->getDisplay($i);
        }

        return implode($this->separator, $result);
    }

    /**
     * This is the function where we manage the actual replacement.
     * We could replace only by the first divisor found or twist the rule at will.
     *
     * @param int $number
     *
     * @return string
     */
    private function getDisplay(int $number): string
    {
        $replacements = [];

        foreach ($this->divisors as $divisor => $replacement) {
            if ($number % $divisor === 0) {
                $replacements[] = $replacement;
            }
        }

        if (!empty($replacements)) {
            return implode('', $replacements);
        }

        return "$number";
    }
}


$fizzBuzz = new FizzBuzz();
echo $fizzBuzz->replaceNumbers(30);