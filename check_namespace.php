<?php
function checkNamespaceIssues($directory) {
    $files = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($directory));
    $issues = [];
    
    foreach ($files as $file) {
        if ($file->isFile() && $file->getExtension() === 'php') {
            $content = file_get_contents($file->getPathname());
            
            // التحقق من وجود مسافات قبل <?php
            if (preg_match('/^\s+<\?php/', $content)) {
                $issues[] = $file->getPathname();
            }
            
            // التحقق من وجود محتوى قبل namespace
            if (preg_match('/<\?php\s+.+\s+namespace/', $content)) {
                $issues[] = $file->getPathname() . ' (محتوى قبل namespace)';
            }
        }
    }
    
    return $issues;
}

echo " فحص ملفات PHP للتحقق من مشاكل namespace...\n";

$issues = checkNamespaceIssues(_DIR_ . '/app');

if (empty($issues)) {
    echo "  جميع الملفات سليمة\n";
} else {
    echo "❌ تم العثور على مشاكل في الملفات التالية:\n";
    foreach ($issues as $issue) {
        echo " - $issue\n";
    }
}
