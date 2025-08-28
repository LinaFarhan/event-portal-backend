 USE event_management;

-- إدراج مستخدمين عينة (كلمات المرور: "password" مشفرة)
INSERT INTO users (username, email, password, created_at, updated_at) VALUES 
('admin', 'admin@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('user1', 'user1@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW()),
('user2', 'user2@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', NOW(), NOW());

-- إدراج فعاليات عينة
INSERT INTO events (title, description, date, time, location, category, created_by, created_at, updated_at) VALUES 
('مؤتمر التقنية 2023', 'أكبر مؤتمر تقني في المنطقة يضم أحدث الابتكارات في مجال التكنولوجيا', '2023-12-15', '09:00:00', 'فندق الماريوت - الرياض', 'مؤتمر', 1, NOW(), NOW()),
('ورشة تطوير الويب', 'ورشة عملية لتعلم تطوير تطبيقات الويب باستخدام أحدث التقنيات', '2023-12-20', '14:00:00', 'جامعة الملك سعود - معمل الحاسوب', 'ورشة عمل', 2, NOW(), NOW()),
('ندوة الذكاء الاصطناعي', 'ندوة تناقش مستقبل الذكاء الاصطناعي وتأثيره على سوق العمل', '2024-01-10', '10:00:00', 'مركز المؤتمرات - جدة', 'ندوة', 1, NOW(), NOW()),
('ملتقى ريادة الأعمال', 'ملتقى يجمع رواد الأعمال والمستثمرين لعرض أفكارهم المشاريع', '2024-02-15', '11:00:00', 'مركز الرياض للمؤتمرات', 'ملتقى', 2, NOW(), NOW()),
('دورة أمن المعلومات', 'دورة متخصصة في أساسيات أمن المعلومات والحماية من الاختراقات', '2024-03-20', '15:00:00', 'كلية الحاسب - جامعة الملك سعود', 'دورة', 1, NOW(), NOW());

-- إدراج متحدثين عينة
INSERT INTO speakers (name, bio, expertise, email, phone, created_at, updated_at) VALUES 
('د. أحمد السعدي', 'خبير في تقنية المعلومات مع أكثر من 15 سنة خبرة في مجال الأمن السيبراني', 'الأمن السيبراني', 'ahmed@example.com', '0512345678', NOW(), NOW()),
('أ. فاطمة العبدالله', 'متخصصة في التسويق الرقمي وتحليل البيانات مع خبرة في كبرى الشركات', 'التسويق الرقمي', 'fatima@example.com', '0554321098', NOW(), NOW()),
('د. محمد القحطاني', 'باحث في مجال الذكاء الاصطناعي وتعلم الآلة، حاصل على براءات اختراع متعددة', 'الذكاء الاصطناعي', 'mohammed@example.com', '0501234567', NOW(), NOW()),
('م. سارة الحربي', 'مطورة واجهات مستخدم بخبرة واسعة في frameworks الحديثة', 'تطوير الويب', 'sara@example.com', '0567890123', NOW(), NOW()),
('د. علي الشمري', 'أستاذ محاضر في مجال علوم البيانات وتحليل الأنظمة', 'علوم البيانات', 'ali@example.com', '0543210987', NOW(), NOW());

-- ربط المتحدثين بالفعاليات
INSERT INTO event_speakers (event_id, speaker_id) VALUES 
(1, 1), (1, 2),  -- مؤتمر التقنية: د. أحمد + أ. فاطمة
(2, 3), (2, 4),  -- ورشة الويب: د. محمد + م. سارة
(3, 1), (3, 3),  -- ندوة الذكاء الاصطناعي: د. أحمد + د. محمد
(4, 2), (4, 5),  -- ملتقى ريادة الأعمال: أ. فاطمة + د. علي
(5, 1), (5, 5);  -- دورة أمن المعلومات: د. أحمد + د. علي

-- إدراج حضور عينة
INSERT INTO attendees (event_id, name, email, phone, registered_at) VALUES 
(1, 'لينا فرحان', 'lina@gmail.com', '0511111111', NOW()),
(1, 'سلوى فرحان', 'salwa@gmail.com', '0522222222', NOW()),
(1, 'فهد أحمد', 'fahad@gmail.com', '0533333333', NOW()),
(2, 'عبدالعزيز فرحان', 'abdulaziz@gmail.com', '0544444444', NOW()),
(2, 'نورة محمد', 'nora@gmail.com', '0555555555', NOW()),
(3, 'ليث فرحان', 'leith@gmail.com', '0566666666', NOW()),
(3, 'سعيد علي', 'saeed@gmail.com', '0577777777', NOW()),
(4, 'مها عبدالله', 'maha@gmail.com', '0588888888', NOW()),
(4, 'خالد سعد', 'khaled@gmail.com', '0599999999', NOW()),
(5, 'أحلام حسن', 'ahlam@gmail.com', '0500000000', NOW()),
(5, 'ياسر ناصر', 'yasser@gmail.com', '0512345000', NOW());

-- التحقق من عدد السجلات في كل جدول
SELECT 
    'المستخدمون' as table_name, 
    COUNT(*) as count 
FROM users
UNION ALL
SELECT 
    'الفعاليات', 
    COUNT(*) 
FROM events
UNION ALL
SELECT 
    'المتحدثون', 
    COUNT(*) 
FROM speakers
UNION ALL
SELECT 
    'ربط المتحدثين', 
    COUNT(*) 
FROM event_speakers
UNION ALL
SELECT 
    'الحضور', 
    COUNT(*) 
FROM attendees;