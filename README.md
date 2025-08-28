 🔌 نظام إدارة الفعاليات (Event Management System)
🔌 نظرة عامة
مشروع ويب متكامل لإدارة الفعاليات، يتيح:
- إدارة الفعاليات (إضافة، تعديل، حذف، عرض التفاصيل)
- إدارة المتحدثين والجمهور
- التحقق من تعارض الجدولة
- تصدير البيانات
- تخصيص المظهر (فاتح/داكن)

---

 🔌 الواجهة (Frontend)
تم بناء الواجهة باستخدام *Vue.js 3* مع واجهة مستخدم تفاعلية وسريعة.

### المكتبات والأدوات
- *Vue.js 3* — إطار العمل الأساسي
- *Vite* — أداة تشغيل وبناء
- *Tailwind CSS* — تصميم الواجهة (Responsive + Dark Mode)
- *Vue Router* — نظام التوجيه
- *Axios + Vue Axios* — جلب البيانات من API
- *Vue Toastification* — إشعارات (Toast)
- *LocalStorage API* — تخزين محلي للبيانات والإعدادات

🔌 ميزات الواجهة
- واجهة متجاوبة (Responsive UI)
- وضع الليل/النهار
- SPA (تطبيق صفحة واحدة)
- تحقق من صحة البيانات
- تصدير بيانات (CSV, Excel)
- إشعارات فورية (Toast)

---

🔌(Backend)
تم بناء الـ Backend باستخدام *PHP 8* بنمط *MVC* مع قاعدة بيانات MySQL.

🔌 المكتبات والأدوات
- *PHP 8+* — لغة البرمجة
- *MySQL* — قاعدة البيانات
- *PDO* — للتعامل مع قاعدة البيانات
- *Composer* — إدارة الحزم
- *JWT (JSON Web Token)* — المصادقة
- *CORS* — دعم الوصول من الواجهة
- *Autoloader* — التحميل التلقائي للكلاسات

🔌ميزات الباكند
- بنية MVC واضحة
- مصادقة JWT
- نظام توجيه (Routing) مخصص
- تحقق من البيانات
- معالجة الأخطاء
- دعم CORS

---

🔌 قاعدة البيانات
الجداول الرئيسية:
- *users* — المستخدمون
- *events* — الفعاليات
- *speakers* — المتحدثون
- *event_speakers* — علاقة many-to-many بين الفعاليات والمتحدثين
- *attendees* — الحضور

---

🔌 التشغيل محليًا

🔌المتطلبات
- Node.js 16+
- PHP 8.0+
- MySQL 5.7+
- Composer

تشغيل الواجهة
```bash
cd event-management-frontend
npm install
npm run dev


يفتح على: http://localhost:5173

تشغيل الباكند

cd event-management-backend
composer install
php -S localhost:8000 -t public

يفتح على: http://localhost:8000

إعداد قاعدة البيانات

1. إنشاء قاعدة بيانات باسم event_management


2. استيراد ملف: data/database.sql


3. استيراد ملف: data/seed_data.sql (اختياري)




---

🔌 واجهة API (Endpoints)

الفعاليات (Events)

GET /events — جميع الفعاليات

GET /events/{id} — فعالية محددة

POST /events — إضافة فعالية

PUT /events/{id} — تعديل فعالية

DELETE /events/{id} — حذف فعالية


المتحدثون (Speakers)

GET /speakers — جميع المتحدثين

POST /speakers — إضافة متحدث

PUT /speakers/{id} — تعديل متحدث

DELETE /speakers/{id} — حذف متحدث


المصادقة (Authentication)

POST /auth/login — تسجيل الدخول
