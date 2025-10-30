<?php

namespace IW_Helper\Utilities\Framework\Interaction;

abstract class IW_Helper_form {
    public array $required_files;
    

    public abstract function render();

    public abstract function is_submited() : bool;

    public abstract function on_submit();
}