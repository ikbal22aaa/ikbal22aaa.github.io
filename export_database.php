<?php
// export_database.php - Export complete database to SQL file
require 'config.php';

$outputFile = 'database_export_' . date('Y-m-d_H-i-s') . '.sql';

echo "=== Exporting Database ===" . PHP_EOL . PHP_EOL;

// Get all tables
$tables = [];
$result = $pdo->query("SHOW TABLES");
while ($row = $result->fetch(PDO::FETCH_NUM)) {
    $tables[] = $row[0];
}

$sqlDump = "-- Database Export for ecommerce_db" . PHP_EOL;
$sqlDump .= "-- Generated on: " . date('Y-m-d H:i:s') . PHP_EOL;
$sqlDump .= "-- " . PHP_EOL . PHP_EOL;

$sqlDump .= "SET SQL_MODE = \"NO_AUTO_VALUE_ON_ZERO\";" . PHP_EOL;
$sqlDump .= "SET time_zone = \"+00:00\";" . PHP_EOL . PHP_EOL;

// Export each table
foreach ($tables as $table) {
    echo "Exporting table: $table..." . PHP_EOL;
    
    // Drop table if exists
    $sqlDump .= "-- " . PHP_EOL;
    $sqlDump .= "-- Table structure for table `$table`" . PHP_EOL;
    $sqlDump .= "-- " . PHP_EOL . PHP_EOL;
    $sqlDump .= "DROP TABLE IF EXISTS `$table`;" . PHP_EOL;
    
    // Create table
    $createTable = $pdo->query("SHOW CREATE TABLE `$table`")->fetch();
    $sqlDump .= $createTable[1] . ";" . PHP_EOL . PHP_EOL;
    
    // Insert data
    $rows = $pdo->query("SELECT * FROM `$table`");
    $rowCount = 0;
    
    if ($rows->rowCount() > 0) {
        $sqlDump .= "-- " . PHP_EOL;
        $sqlDump .= "-- Dumping data for table `$table`" . PHP_EOL;
        $sqlDump .= "-- " . PHP_EOL . PHP_EOL;
        
        while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
            $columns = array_keys($row);
            $values = array_values($row);
            
            // Escape values
            $escapedValues = array_map(function($value) use ($pdo) {
                if ($value === null) {
                    return 'NULL';
                }
                return $pdo->quote($value);
            }, $values);
            
            $sqlDump .= "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES (" . implode(', ', $escapedValues) . ");" . PHP_EOL;
            $rowCount++;
        }
        
        $sqlDump .= PHP_EOL;
        echo "  → Exported $rowCount rows" . PHP_EOL;
    } else {
        echo "  → No data to export" . PHP_EOL;
    }
}

// Write to file
file_put_contents($outputFile, $sqlDump);

echo PHP_EOL . "✓ Database exported successfully!" . PHP_EOL;
echo "✓ File saved as: $outputFile" . PHP_EOL;
echo "✓ File size: " . number_format(filesize($outputFile) / 1024, 2) . " KB" . PHP_EOL;
?>