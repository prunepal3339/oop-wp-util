<?php
namespace WPOOPUtil\View;

abstract class AbstractView
{
    private array $data;
    private array $styles;

    public function render(array $data = [], array $styles = []): string
    {
        $this->data = $data;
        $this->styles = $styles;
        return $this->buildView();
    }
    abstract protected function buildView(): string;
}
