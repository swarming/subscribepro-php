<?php

namespace SubscribePro;

/**
 * @param string $name
 * @return string
 */
function camelize($name)
{
    return implode('', array_map('ucfirst', explode('_', $name)));
}

/**
 * @param string $name
 * @return string
 */
function underscore($name)
{
    $result = strtolower(trim(preg_replace('/([A-Z]|[0-9]+)/', "_$1", $name), '_'));
    return $result;
}

/**
 * @param string $date
 * @param string $outputFormat
 * @param string $inputFormat
 * @return string
 */
function formatDate($date, $outputFormat, $inputFormat = \DateTime::ISO8601)
{
    if (!$outputFormat) {
        return $date;
    }

    $dateTime = \DateTime::createFromFormat($inputFormat, $date);
    return $dateTime ? $dateTime->format($outputFormat) : $date;
}
