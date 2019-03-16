<?php

namespace App\Shell;

use Cake\Console\Shell;

class SampleShell extends Shell
{
    public function main()
    {
        $this->out('これはサンプルです。');
    }
}
