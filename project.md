# Ferry Backend

Laravel admin/backend สำหรับระบบจองเรือเฟอร์รี่ (Ferry Application)

## Stack

| Layer | Technology |
| --- | --- |
| Backend | Laravel 10 (`php ^8.1`) |
| Auth / API | Laravel Passport, Sanctum |
| UI Template | **Smarty 5.0.7** (Bootstrap 5) |
| PDF | barryvdh/laravel-dompdf |
| Other | Guzzle, JWT, Line Notify, milon/barcode |

## UI: Smarty 5.0.7

โปรเจกต์นี้ใช้เทมเพลต **Smarty** เวอร์ชัน **5.0.7** เป็น UI ของฝั่ง admin

- Documentation: [Smarty 5.0.7 – Frontend Docs](https://smarty.stepofweb.com/5.0.7/html_frontend/documentation/index.html)
- Smarty 5 ใช้ major version เดียวกับ Bootstrap 5
- jQuery ถูกแพ็กอยู่ใน `core.min.js` (ไม่ต้อง include แยก)
- Plugin ส่วนใหญ่โหลดตาม HTML class / attribute (SOW plugins) ไม่ต้องเขียน JS/CSS เริ่มต้นเองมาก

### Assets ในโปรเจกต์

ไฟล์ Smarty อยู่ใต้ `public/assets/`:

| File | Role |
| --- | --- |
| `assets/css/core.min.css` | Smarty / Bootstrap core styles |
| `assets/css/vendor_bundle.min.css` | Vendor CSS bundle |
| `assets/css/style.css` | Custom overrides ของโปรเจกต์ |
| `assets/js/core.min.js` | Core JS (รวม jQuery) |
| `assets/js/vendor_bundle.min.js` | Vendor JS (รวม Bootstrap) |
| `assets/js/app/*.js` | Custom JS ต่อหน้า (booking, route, station, …) |
| `assets/fonts/flaticon/` | Smarty icon font |

Include หลักอยู่ที่:

- `resources/views/includes/head.blade.php` — CSS
- `resources/views/includes/script.blade.php` — JS
- Layout หลัก: `resources/views/layouts/default.blade.php` (`layout-admin`)

### เมื่อสร้าง / แก้หน้า UI

1. ดูเอกสาร Smarty ก่อน (components, forms, SOW plugins, vendor plugins)
2. ใช้ class / attribute ของ Smarty ให้ตรงกับเอกสาร เพื่อให้ plugin โหลดอัตโนมัติ
3. ใส่ custom CSS ใน `public/assets/css/style.css` (อย่าแก้ `core.min.css` โดยตรงถ้าไม่จำเป็น)
4. ใส่ custom JS ต่อหน้าใน `public/assets/js/app/` หรือ `@section('script')` ใน Blade

อ้างอิงด่วนจาก docs:

- Components & Elements (alerts, buttons, cards, tables, forms, …)
- SOW Core Plugins (Ajax Forms/Modals/Confirm, Form Validation, Datatable, Toasts, …)
- Vendor Plugins (Datepicker, Summernote, Chart.js, Fullcalendar, …)

## โครงสร้างสำคัญ

```
app/
  Http/Controllers/     # Web + API controllers
  Services/             # External API services (เช่น Change168)
  Helpers/              # Autoloaded helpers
resources/views/
  layouts/              # default, blank, ajaxmodal
  includes/             # head, header, sidebar, script
  pages/                # หน้า admin แต่ละโมดูล
  components/           # Blade components
public/assets/          # Smarty assets + app JS/CSS
routes/web.php          # Web routes
routes/api.php          # API routes
```

## Helper `_()`

Blade หลายไฟล์ใช้ `_('...')` เป็น shortcut แปลข้อความ  
นิยามอยู่ที่ `app/Helpers/TranslationHelper.php` (autoload ผ่าน `composer.json`) และ map ไปที่ Laravel `__()`

## รันท้องถิ่น

```bash
composer install
cp .env.example .env   # ถ้ายังไม่มี
php artisan key:generate
php artisan serve --port=8005
```

ตั้งค่า DB / API keys ใน `.env` ตาม environment จริง

## หมายเหตุ

- หน้า admin ใช้ body class `layout-admin` ตามแพทเทิร์น Smarty admin
- เมื่อเพิ่ม UI ใหม่ ให้คงรูปแบบ Bootstrap 5 + Smarty utilities / SOW attributes ให้สอดคล้องกับหน้าเดิม
- เอกสาร Smarty: https://smarty.stepofweb.com/5.0.7/html_frontend/documentation/index.html
