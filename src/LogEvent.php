<?php

namespace Yosmy;

interface LogEvent
{
    /**
     * @param array $labels
     * @param array $involved
     * @param array $extra
     */
    public function log(
        array $labels,
        array $involved,
        array $extra
    );
}