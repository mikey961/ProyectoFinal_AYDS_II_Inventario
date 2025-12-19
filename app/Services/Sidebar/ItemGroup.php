<?php 

namespace App\Services\Sidebar;

class ItemGroup implements ItemInterface
{
    private string $title;
    private string $icon;
    private bool $active;
    private array $items = [];

    public function __construct(string $title, string $icon, bool $active)
    {
        $this->title = $title;
        $this->icon = $icon;
        $this->active = $active;
    }

    public function addItem(ItemInterface $item): self
    {
        $this->items[] = $item;
        return $this;
    }

    public function render(): string
    {
        $isOpenInitial = $this->active ? 'true' : 'false';
        $itemsHtml = collect($this->items)
            ->map(function (ItemInterface $item) {
                return '<li class="pl-4">' . $item->render() . '</li>';
            })->implode("\n");

        return <<<HTML
            <div x-data="{ open: {$isOpenInitial} }">
                <button type="button"
                    @click= "open = !open"
                    class="flex items-center w-full p-2 text-base text-white transition duration-75 rounded-lg group hover:bg-blue-500">
                        <span class="w-6 h-6 inline-flex justify-center items-center text-white">
                            <i class="{ $this->icon }"></i>
                        </span>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap font-bold">
                            {$this->title}
                        </span>
                        <i class="text-sm" 
                            :class="{
                                'fa-solid fa-chevron-up' : open,
                                'fa-solid fa-chevron-down' : !open,
                            }">
                        </i>
                </button>
                <ul x-show="open" 
                    x-cloak class="py-2 space-y-2">
                    {$itemsHtml}
                </ul>
            </div>
        HTML;
    }

    public function authorize(): bool
    {
        return true;
    }
}