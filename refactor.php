<?php

$dir = __DIR__;

$modelsDir = $dir . '/app/Models';

$renames = [
    'attendance' => 'Attendance',
    'leaves' => 'Leave',
    'logbook' => 'Logbook',
    'tpdk' => 'Tpdk',
];

echo "Renaming files and classes in app/Models...\n";
foreach ($renames as $old => $new) {
    $oldFile = $modelsDir . '/' . $old . '.php';
    $newFile = $modelsDir . '/' . $new . '.php';
    
    if (file_exists($oldFile)) {
        $content = file_get_contents($oldFile);
        $content = preg_replace('/class\s+' . $old . '\s+extends/', 'class ' . $new . ' extends', $content);
        // Force table name if it's not the default plural of the new name
        if ($old === 'leaves' && !str_contains($content, 'protected $table')) {
            $content = preg_replace('/class\s+Leave\s+extends\s+Model\s*\{/', "class Leave extends Model\n{\n    protected \$table = 'leaves';\n", $content);
        }
        if ($old === 'attendance' && !str_contains($content, 'protected $table')) {
            $content = preg_replace('/class\s+Attendance\s+extends\s+Model\s*\{/', "class Attendance extends Model\n{\n    protected \$table = 'attendances';\n", $content);
        }
        if ($old === 'logbook' && !str_contains($content, 'protected $table')) {
             $content = preg_replace('/class\s+Logbook\s+extends\s+Model\s*\{/', "class Logbook extends Model\n{\n    protected \$table = 'logbooks';\n", $content);
        }
        if ($old === 'tpdk' && !str_contains($content, 'protected $table')) {
             $content = preg_replace('/class\s+Tpdk\s+extends\s+Model\s*\{/', "class Tpdk extends Model\n{\n    protected \$table = 'tpdks';\n", $content);
        }

        file_put_contents($oldFile, $content);
        rename($oldFile, $newFile);
        echo "Renamed $old.php to $new.php\n";
    } else {
        echo "File $old.php not found in $modelsDir\n";
    }
}

function processDirectory($path, $renames) {
    if (!is_dir($path)) return;
    $iterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($path));
    foreach ($iterator as $file) {
        if ($file->isDir()) continue;
        if ($file->getExtension() !== 'php') continue;
        
        $filepath = $file->getPathname();
        $content = file_get_contents($filepath);
        $originalContent = $content;
        
        foreach ($renames as $old => $new) {
            // Namespace imports
            $content = preg_replace('/use\s+App\\\\Models\\\\' . $old . '\s*;/', 'use App\Models\\' . $new . ';', $content);
            
            // Class usage: old::
            $content = preg_replace('/\b' . $old . '::/', $new . '::', $content);
            
            // Instantiation: new old
            $content = preg_replace('/\bnew\s+' . $old . '\b/', 'new ' . $new, $content);
            
            // Type hinting: function(old $var)
            $content = preg_replace('/\b' . $old . '\s+\$/', $new . ' $', $content);
            
            // PHPDoc @var or @return old
            $content = preg_replace('/@param\s+' . $old . '\b/', '@param ' . $new, $content);
            $content = preg_replace('/@return\s+' . $old . '\b/', '@return ' . $new, $content);
            $content = preg_replace('/@var\s+' . $old . '\b/', '@var ' . $new, $content);

            // Class resolution: old::class
            $content = preg_replace('/\b' . $old . '::class/', $new . '::class', $content);
        }
        
        if ($content !== $originalContent) {
            file_put_contents($filepath, $content);
            echo "Updated references in $filepath\n";
        }
    }
}

echo "Updating references in app/ ...\n";
processDirectory($dir . '/app', $renames);

echo "Updating references in routes/ ...\n";
processDirectory($dir . '/routes', $renames);

echo "Updating references in database/ ...\n";
processDirectory($dir . '/database', $renames);

echo "Done.\n";
