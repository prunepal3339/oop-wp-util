<?php
namespace WPOOPUtil\Admin;
use WPOOPUtil\View\AbstractView;
abstract class AbstractAdminPage extends AbstractView
{
    protected string $pageTitle;
    protected string $menuTitle;
    protected string $capability;
    protected string $parentSlug;
    protected string $slug;
    protected string $iconUrl;
    protected $position = null;

    public function __construct(array $params = [])
    {
        if (array_key_exists("parent_slug", $params)) {
            $this->parentSlug = $params["parent_slug"];
        }
        if (array_key_exists("page_title", $params)) {
            $this->pageTitle = $params["page_title"];
        }
        if (array_key_exists("menu_title", $params)) {
            $this->menuTitle = $params["menu_title"];
        }
        if (array_key_exists("capability", $params)) {
            $this->capability = $params["capability"];
        }
        if (array_key_exists("slug", $params)) {
            $this->slug = $params["slug"];
        }
        if (array_key_exists("position", $params)) {
            $this->position = $params["position"];
        }
        if (array_key_exists("icon_url", $params)) {
            $this->iconUrl = $params["icon_url"];
        }
    }
    public function show(): void
    {
        if (isset($this->parentSlug)) {
            add_action("admin_menu", [$this, "addSubmenu"]);
        } else {
            add_action("admin_menu", [$this, "addMenu"]);
        }
        // add_action("admin_init", [$this, "configure"]);
    }
    public function addMenu(): void
    {
        // add_menu_page(
        //     "Menu Page",
        //     "Menu Title",
        //     "test-plugin",
        //     "manage_options",
        //     "",
        //     "dashicons-chart-pie",
        //     100
        // );
        // add_menu_page(
        //     $this->getPageTitle(),
        //     $this->getMenuTitle(),
        //     $this->getSlug(),
        //     $this->getCapability(),
        //     [$this, "render"],
        //     $this->getIconUrl(),
        //     $this->getPosition()
        // );
    }
    public function addSubmenu(): void
    {
        add_submenu_page(
            $this->getParentSlug(),
            $this->getPageTitle(),
            $this->getMenuTitle(),
            $this->getCapability(),
            $this->getSlug(),
            [$this, "render"],
            $this->getPosition()
        );
    }
    public function getPageTitle(): string
    {
        return $this->pageTitle;
    }
    public function getMenuTitle(): string
    {
        return $this->menuTitle;
    }
    public function getCapability(): string
    {
        return $this->capability;
    }
    public function getParentSlug(): string
    {
        return $this->parentSlug;
    }
    public function getSlug(): string
    {
        return $this->slug;
    }
    public function getPosition(): ?int
    {
        return $this->position;
    }
    public function getIconUrl(): ?string
    {
        return $this->iconUrl;
    }
    abstract public function configure(): void;
    // {
    //     // // Register settings
    //     // register_setting($this->getSlug(), "ooputil_option"); // option_group & option_name
    //     // // option_group: settings group that the setting will belong to.
    //     // // option_name: actual setting that we want to register

    //     // add_settings_section(
    //     //     $this->getSlug() . "-section",
    //     //     __("Section Title", "ooputil"),
    //     //     [$this, "renderSection"],
    //     //     $this->getSlug()
    //     // );

    //     // add_settings_field(
    //     //     $this->getSlug() . "-option",
    //     //     __("My option", "ooputil"),
    //     //     [$this, "renderOptionField"],
    //     //     $this->getSlug(),
    //     //     $this->getSlug() . "-section"
    //     // );
    // }

    //     public function renderSection(): string
    //     {
    //         return <<<'EOL'
    // <div>Section Div</div>
    // EOL;
    //     }
    //     public function renderOptionField(): string
    //     {
    //         return <<<'EOL'
    // <div>Option Field</div>
    // EOL;
    //     }

    //     protected function buildView(): string
    //     {
    //         return <<<EOL
    // <div>Admin Page Here?</div>
    // EOL;
    //     }
}
// Two methods need to be defined by subclass
// 1. buildView:
// 2. configure:
// to build an AdminPage
