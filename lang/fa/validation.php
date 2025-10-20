<?php

return [

    /*
    |--------------------------------------------------------------------------
    | خطوط زبان اعتبارسنجی
    |--------------------------------------------------------------------------
    |
    | خطوط زبان زیر شامل پیام‌های خطای پیش‌فرض مورد استفاده در کلاس
    | اعتبارسنجی هستند. برخی از این قوانین دارای چندین نسخه هستند،
    | مانند قوانین مربوط به اندازه. شما می‌توانید این پیام‌ها را تغییر دهید.
    |
    */

    'accepted' => 'فیلد :attribute باید پذیرفته شود.',
    'accepted_if' => 'فیلد :attribute باید پذیرفته شود زمانی که :other مقدار :value باشد.',
    'active_url' => 'فیلد :attribute باید یک URL معتبر باشد.',
    'after' => 'فیلد :attribute باید تاریخی بعد از :date باشد.',
    'after_or_equal' => 'فیلد :attribute باید تاریخی بعد یا برابر با :date باشد.',
    'alpha' => 'فیلد :attribute فقط باید شامل حروف باشد.',
    'alpha_dash' => 'فیلد :attribute فقط باید شامل حروف، اعداد، خط فاصله و زیرخط باشد.',
    'alpha_num' => 'فیلد :attribute فقط باید شامل حروف و اعداد باشد.',
    'array' => 'فیلد :attribute باید یک آرایه باشد.',
    'ascii' => 'فیلد :attribute باید فقط شامل کاراکترهای الفبایی تک‌بایتی و نمادها باشد.',
    'before' => 'فیلد :attribute باید تاریخی قبل از :date باشد.',
    'before_or_equal' => 'فیلد :attribute باید تاریخی قبل یا برابر با :date باشد.',
    'between' => [
        'array' => 'فیلد :attribute باید بین :min و :max مورد داشته باشد.',
        'file' => 'فیلد :attribute باید بین :min و :max کیلوبایت باشد.',
        'numeric' => 'فیلد :attribute باید بین :min و :max باشد.',
        'string' => 'فیلد :attribute باید بین :min و :max کاراکتر باشد.',
    ],
    'boolean' => 'فیلد :attribute باید مقدار true یا false داشته باشد.',
    'confirmed' => 'تأییدیه فیلد :attribute مطابقت ندارد.',
    'current_password' => 'رمز عبور اشتباه است.',
    'date' => 'فیلد :attribute باید یک تاریخ معتبر باشد.',
    'date_equals' => 'فیلد :attribute باید تاریخی برابر با :date باشد.',
    'date_format' => 'فیلد :attribute باید با فرمت :format باشد.',
    'decimal' => 'فیلد :attribute باید دارای :decimal رقم اعشار باشد.',
    'different' => 'فیلد :attribute و :other باید متفاوت باشند.',
    'digits' => 'فیلد :attribute باید :digits رقم باشد.',
    'digits_between' => 'فیلد :attribute باید بین :min و :max رقم باشد.',
    'dimensions' => 'ابعاد تصویر فیلد :attribute نامعتبر است.',
    'distinct' => 'فیلد :attribute مقدار تکراری دارد.',
    'email' => 'فیلد :attribute باید یک آدرس ایمیل معتبر باشد.',
    'ends_with' => 'فیلد :attribute باید با یکی از موارد زیر پایان یابد: :values.',
    'enum' => 'مقدار انتخاب‌شده برای :attribute نامعتبر است.',
    'exists' => 'مقدار انتخاب‌شده برای :attribute نامعتبر است.',
    'file' => 'فیلد :attribute باید یک فایل باشد.',
    'filled' => 'فیلد :attribute باید مقدار داشته باشد.',
    'gt' => [
        'array' => 'فیلد :attribute باید بیشتر از :value مورد داشته باشد.',
        'file' => 'فیلد :attribute باید بیشتر از :value کیلوبایت باشد.',
        'numeric' => 'فیلد :attribute باید بزرگ‌تر از :value باشد.',
        'string' => 'فیلد :attribute باید بیشتر از :value کاراکتر باشد.',
    ],
    'image' => 'فیلد :attribute باید یک تصویر باشد.',
    'in' => 'مقدار انتخاب‌شده برای :attribute نامعتبر است.',
    'integer' => 'فیلد :attribute باید یک عدد صحیح باشد.',
    'ip' => 'فیلد :attribute باید یک آدرس IP معتبر باشد.',
    'json' => 'فیلد :attribute باید یک مقدار JSON معتبر باشد.',
    'max' => [
        'array' => 'فیلد :attribute نباید بیشتر از :max مورد داشته باشد.',
        'file' => 'فیلد :attribute نباید بیشتر از :max کیلوبایت باشد.',
        'numeric' => 'فیلد :attribute نباید بزرگ‌تر از :max باشد.',
        'string' => 'فیلد :attribute نباید بیشتر از :max کاراکتر باشد.',
    ],
    'min' => [
        'array' => 'فیلد :attribute باید حداقل :min مورد داشته باشد.',
        'file' => 'فیلد :attribute باید حداقل :min کیلوبایت باشد.',
        'numeric' => 'فیلد :attribute باید حداقل :min باشد.',
        'string' => 'فیلد :attribute باید حداقل :min کاراکتر باشد.',
    ],
    'not_in' => 'مقدار انتخاب‌شده برای :attribute نامعتبر است.',
    'numeric' => 'فیلد :attribute باید یک عدد باشد.',
    'password' => [
        'letters' => 'فیلد :attribute باید حداقل یک حرف داشته باشد.',
        'mixed' => 'فیلد :attribute باید حداقل یک حرف بزرگ و یک حرف کوچک داشته باشد.',
        'numbers' => 'فیلد :attribute باید حداقل یک عدد داشته باشد.',
        'symbols' => 'فیلد :attribute باید حداقل یک نماد داشته باشد.',
        'uncompromised' => 'رمز عبور انتخاب‌شده در یک نشت اطلاعاتی یافت شده است. لطفاً رمز عبور دیگری انتخاب کنید.',
    ],
    'regex' => 'فرمت فیلد :attribute نامعتبر است.',
    'required' => 'فیلد :attribute الزامی است.',
    'same' => 'فیلد :attribute باید با :other مطابقت داشته باشد.',
    'size' => [
        'array' => 'فیلد :attribute باید شامل :size مورد باشد.',
        'file' => 'فیلد :attribute باید :size کیلوبایت باشد.',
        'numeric' => 'فیلد :attribute باید :size باشد.',
        'string' => 'فیلد :attribute باید :size کاراکتر باشد.',
    ],
    'string' => 'فیلد :attribute باید یک رشته باشد.',
    'timezone' => 'فیلد :attribute باید یک منطقه زمانی معتبر باشد.',
    'unique' => 'فیلد :attribute قبلاً استفاده شده است.',
    'uploaded' => 'بارگذاری فیلد :attribute ناموفق بود.',
    'url' => 'فیلد :attribute باید یک URL معتبر باشد.',

    /*
    |--------------------------------------------------------------------------
    | خطوط زبان اعتبارسنجی سفارشی
    |--------------------------------------------------------------------------
    |
    | در اینجا می‌توانید پیام‌های اعتبارسنجی سفارشی برای ویژگی‌های مختلف
    | را مشخص کنید. این امکان به شما اجازه می‌دهد پیام‌های مشخصی را
    | برای قوانین خاصی تنظیم کنید.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'پیام سفارشی',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | نام‌های سفارشی برای فیلدها
    |--------------------------------------------------------------------------
    |
    | خطوط زیر برای جایگزینی نام‌های فیلدها با نام‌هایی خواناتر و
    | قابل فهم‌تر استفاده می‌شوند.
    |
    */

    'attributes' => [
        // جداول
        'b_accountingsubgroups' => 'زیرگروه های حسابداری',
        'b_apis' => 'API ها',
        'b_apitypes' => 'انواع API',
        'b_banks' => 'بانک ها',
        'b_cities' => 'شهرها',
        'b_codingnatures' => 'طبیعت های کدینگ',
        'b_codingtypes' => 'انواع کدینگ',
        'b_invoicetypes' => 'انواع فاکتور',
        'b_menus' => 'منوها',
        'b_productcategories' => 'دسته بندی محصولات',
        'b_provinces' => 'استان ها',
        'b_roles' => 'نقش ها',
        'b_systems' => 'سیستم ها',
        'b_units' => 'واحدها',
        'b_warehousedoctypes' => 'انواع اسناد انبار',
        'failed_jobs' => 'وظایف ناموفق',
        'jobs' => 'وظایف',
        'm_accountingdocs' => 'اسناد حسابداری',
        'm_agencies' => 'نمایندگی‌ها',
        'm_bankaccounts' => 'حساب‌های بانکی',
        'm_checkbooks' => 'دفترچه‌های چک',
        'm_codings' => 'کدینگ‌ها',
        'm_companies' => 'شرکت‌ها',
        'm_invoices' => 'فاکتورها',
        'm_moneyboxes' => 'صندوق‌ها',
        'm_pettycashes' => 'تنخواه‌ها',
        'm_products' => 'محصولات',
        'm_verifications' => 'تأییدیه‌ها',
        'm_warehousedocs' => 'اسناد انبار',
        'm_warehouses' => 'انبارها',
        'migrations' => 'مهاجرت‌ها',
        'r_menusapis' => 'رابط منو و API',
        'r_menusroles' => 'رابط منو و نقش',
        'r_usercompanies' => 'رابط کاربر و شرکت',
        'r_usermenushortcuts' => 'میانبرهای منوی کاربر',
        'r_usersroles' => 'رابط کاربر و نقش',
        'r_warehouseproducts' => 'محصولات انبار',
        's_accountingdocdetails' => 'جزئیات سند حسابداری',
        's_accountingsubs' => 'ریز حساب‌ها',
        's_checkbookdetails' => 'جزئیات دفترچه چک',
        's_finacialreqdetails' => 'جزئیات درخواست مالی',
        's_invoicedetails' => 'جزئیات فاکتور',
        's_menucolumns' => 'ستون‌های منو',
        's_useraddresses' => 'آدرس‌های کاربر',
        's_warehousedocdetails' => 'جزئیات سند انبار',
        'users' => 'کاربران',

        // فیلدهای عمومی
        'pk_*' => 'شناسه',
        'fk_*' => 'کلید خارجی',
        'created_at' => 'تاریخ ایجاد',
        'updated_at' => 'تاریخ بروزرسانی',
        'isenable' => 'فعال',
        'isactive' => 'فعال',

        // b_accountingsubgroups
        'accountingsubgroup' => 'زیرگروه حسابداری',

        // b_apis
        'api' => 'API',
        'fk_apitype' => 'نوع API',

        // b_banks
        'bank' => 'بانک',
        'bankicon' => 'آیکون بانک',

        // b_cities
        'city' => 'شهر',
        'fk_province' => 'استان',

        // b_codingnatures
        'codingnature' => 'طبیعت کدینگ',

        // b_codingtypes
        'codingtype' => 'نوع کدینگ',

        // b_invoicetypes
        'invoicetype' => 'نوع فاکتور',

        // b_menus
        'menu' => 'منو',
        'menulevel' => 'سطح منو',
        'menusec' => 'منو ثانویه',
        'path' => 'مسیر',
        'component' => 'کامپوننت',
        'icon' => 'آیکون',
        'ordernumber' => 'ترتیب نمایش',

        // b_productcategories
        'productcategory' => 'دسته بندی محصول',
        'descriptions' => 'توضیحات',
        'image' => 'تصویر',

        // b_provinces
        'province' => 'استان',

        // b_roles
        'role' => 'نقش',

        // b_systems
        'system' => 'سیستم',

        // b_units
        'unit' => 'واحد',
        'fk_unit' => 'کلید خارجی واحد',

        // b_warehousedoctypes
        'warehousedoctype' => 'نوع سند انبار',

        // m_accountingdocs
        'accountingdocdate' => 'تاریخ سند حسابداری',
        'accountingdoccode' => 'کد سند حسابداری',

        // m_agencies
        'agency' => 'نمایندگی',

        // m_bankaccounts
        'bankaccount' => 'حساب بانکی',
        'cardnumber' => 'شماره کارت',
        'accountnumber' => 'شماره حساب',
        'iban' => 'شماره شبا',

        // m_codings
        'coding' => 'کدینگ',
        'codingcode' => 'کد کدینگ',
        'isforcesub' => 'اجباری بودن زیرمجموعه',

        // m_companies
        'company' => 'شرکت',

        // m_invoices
        'invoicetitle' => 'عنوان فاکتور',
        'invoicecode' => 'کد فاکتور',
        'invoicedocdate' => 'تاریخ فاکتور',
        'duedate' => 'تاریخ سررسید',
        'shipping' => 'هزینه حمل',

        // m_products
        'product' => 'محصول',
        'productsec' => 'محصول ثانویه',
        'barcode' => 'بارکد',
        'conversionfactor' => 'ضریب تبدیل',
        'weight' => 'وزن',
        'height' => 'ارتفاع',
        'width' => 'عرض',
        'color' => 'رنگ',
        'tax' => 'مالیات',
        'keywords' => 'کلمات کلیدی',
        'saleprice' => 'قیمت فروش',
        'buyprice' => 'قیمت خرید',
        'iscommingsoon' => 'به زودی',
        'isavailable' => 'موجود',
        'isforonlinesale' => 'قابل فروش آنلاین',

        // users
        'name' => 'نام',
        'lastname' => 'نام خانوادگی',
        'nationalcode' => 'کد ملی',
        'birthday' => 'تاریخ تولد',
        'mobile' => 'موبایل',
        'phone' => 'تلفن',
        'email' => 'ایمیل',
        'password' => 'رمز عبور',
        'notificationtoken' => 'توکن اطلاع رسانی',
        'isblock' => 'مسدود شده',
        'subscriptionid' => 'شناسه اشتراک',
        //'image' => 'تصویر',
        'lastlogin' => 'آخرین ورود',
        'firstrelativename' => 'نام اولین رابط',
        'firstrelativephone' => 'تلفن اولین رابط',
        'secondrelativename' => 'نام دومین رابط',
        'secondrelativephone' => 'تلفن دومین رابط',
        'attachments' => 'پیوست ها',
        //'descriptions' => 'توضیحات',

        // s_accountingdocdetails
        'amount' => 'مبلغ',
        'description' => 'توضیحات',

        // s_accountingsubs
        'accountingsub' => 'حساب معین',
        'accountingsubcode' => 'کد حساب معین',

        // s_checkbookdetails
        'serialnumber' => 'شماره سریال',
        //'duedate' => 'تاریخ سررسید',

        // s_invoicedetails
        'feeprice' => 'قیمت واحد',
        'count' => 'تعداد',
        'totalprice' => 'قیمت کل',
        'discountpercent' => 'درصد تخفیف',
        'discountamount' => 'مبلغ تخفیف',
        'taxpercent' => 'درصد مالیات',
        'taxamount' => 'مبلغ مالیات',
        'finalprice' => 'قیمت نهایی',
        'expiredate' => 'تاریخ انقضا',

        // s_warehousedocdetails
        //'finalprice' => 'قیمت نهایی',

        // s_useraddresses
        'useraddress' => 'آدرس کاربر',
        'address' => 'آدرس',
        'postal_address' => 'آدرس پستی',
        'address_compact' => 'آدرس فشرده',
        'last' => 'آخرین',
        'country' => 'کشور',
        'rural_district' => 'بخش',
        'village' => 'روستا',
        'region' => 'منطقه',
        'neighborhood' => 'محله',
        'street' => 'خیابان',
        'plaque' => 'پلاک',
        'postal_code' => 'کد پستی',
        'lat' => 'عرض جغرافیایی',
        'lon' => 'طول جغرافیایی',
        'type' => 'نوع',
        'coordinates' => 'مختصات',
        'floorunit' => 'واحد/طبقه',
    ],

];
