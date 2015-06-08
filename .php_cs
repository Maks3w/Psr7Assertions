<?php

return Symfony\CS\Config\Config::create()
    ->fixers(
        array(
            '-concat_without_spaces',
            '-empty_return',
            '-phpdoc_no_empty_return',
            '-phpdoc_params',
            '-phpdoc_to_comment',
            '-psr0',
            '-single_array_no_trailing_comma',
            'concat_with_spaces',
            'ereg_to_preg',
            'ordered_use',
        )
    )
    ->finder(
        Symfony\CS\Finder\DefaultFinder::create()
            ->in('src')
            ->in('test')
    )
    ;
