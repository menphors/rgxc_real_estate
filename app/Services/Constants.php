<?php

/**
 * Class Constants
 * This class is used to hold all constants in this system.
 */
class Constants
{
    public const LIMIT = 20;
    public const TYPE_SALE = 1;
    public const TYPE_DEPOSIT = 2;

    public const PROPERTY_STATUS =[
        "padding" => 0,
        "submitted" => 1,
        "reviewed" => 2,
        "published" => 3,
        "solved" => 4,
        "deposit" => 5,
        "unpublished" => 6,
    ];

    public const COMMISSION_OWNER_COMPANY = 1;
    public const COMMISSION_STAFF_COMPANY = 2;
    public const COMMISSION_TYPE =[
        self::COMMISSION_OWNER_COMPANY => "Owner With Company",
        self::COMMISSION_STAFF_COMPANY => "Staff With Company",
    ];

    public const COMMISSION_TO_BROKER = 1;
    public const COMMISSION_TO_SALE = 2;
    public const COMMISSION_TO_COLLECTOR = 3;
    public const COMMISSION_TO_AGENT = 4;
    public const COMMISSION_TO =[
        self::COMMISSION_TO_BROKER => "Broker",
        self::COMMISSION_TO_SALE => "Sale",
        self::COMMISSION_TO_COLLECTOR => "Collector",
        self::COMMISSION_TO_AGENT => "Agent/Partner",
    ];

    public const ROLE_KEY_COLLECTOR = 1;
    public const ROLE_KEY_OFFICE = 2;
    public const ROLE_KEY_SALE = 3;
    public const ROLE_KEY_AGENT = 4;


    public const ROLE_TYPE_COLLECTOR = 'collector';
    public const ROLE_TYPE_OFFICE = 'office';
    public const ROLE_TYPE_SALE = 'sale';
    public const ROLE_TYPE_AGENT = 'agent';


    public const CMS_TYPE_WIDGET = 1;
    public const CMS_TYPE_PAGE = 2;
    public const CMS_TYPE_SLIDE_SHOW = 3;
    public const CMS_TYPE_BRAND_CAROUSEL = 4;
    public const CMS_TYPE_BRAND_SIDE_BAR = 5;
    public const CMS_TYPE =[
        self::CMS_TYPE_WIDGET => "Widget",
        self::CMS_TYPE_PAGE => "Page",
        self::CMS_TYPE_SLIDE_SHOW => "Slide Show",
        self::CMS_TYPE_BRAND_CAROUSEL => "Brand Carousel",
        self::CMS_TYPE_BRAND_SIDE_BAR => "Sidebar",
    ];

    public const CMS_PAGE_BLOG_COMPANY_PROFILE = 1;
    public const CMS_PAGE_BLOG_SERVICE = 2;

    public const BLOG_TYPE_WIDGET_HOME_PAGE = 1;
    public const BLOG_TYPE_WIDGET_FOOTER_LEFT = 2;
    public const BLOG_TYPE_WIDGET_FOOTER_RIGHT = 3;
    public const BLOG_TYPE_WIDGET =[
        self::BLOG_TYPE_WIDGET_HOME_PAGE => "Home Content",
        self::BLOG_TYPE_WIDGET_FOOTER_LEFT => "Footer Left",
        self::BLOG_TYPE_WIDGET_FOOTER_RIGHT => "Footer Right",
    ];

    public const BLOG_TYPE_SIDEBAR_PROPERTY_DETAIL = 1;

    public const BLOG_TYPE_PAGE =[
        1 => "Profile",
        2 => "Service",
    ];

}
