<?php

namespace App\Services\Sidebar;

class ItemLink implements ItemInterface
{
    private string $title;
    private string $url;
    private string $icon;
    private bool $active;
    private array $can;

    public function __construct(string $title, string $url, string $icon, bool $active, array $can)
    {
        $this->title = $title;
        $this->url = $url;
        $this->icon = $icon;
        $this->active = $active;
        $this->can = $can;
    }

    public function render(): string
    {
        $activeClass = $this->active ? 'bg-blue-500' : '';

        return <<<HTML
            <a href="{$this->url}"
                class="flex items-center p-2 rounded-lg dark:text-black hover:bg-blue-500 { $activeClass }">
                <span class="w-6 h-6 inline-flex justify-center items-center text-white">
                    <i class="{$this->icon}"></i>
                </span>
                <span class="ms-3 font-bold text-white">
                    {$this->title}
                </span>
            </a>
        HTML;
    }

    public function authorize(): bool
    {
        return true;
    }
}