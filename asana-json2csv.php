<?php

echo "\n\n";
echo "Run asana-json2csv.php...\n\n";

if (php_sapi_name() !== 'cli') {
    echo "ERROR: Please, run in CLI mode:\n";
    echo "Example: php asana-json2csv.php path/to/filename.json\n\n";
    exit();
}

if (empty($argv[1])) {
    exit("ERROR: The json file name or URL is missed\n\n");
}

$json_filename = $argv[1];

if (!file_exists($json_filename)) {
    exit("ERROR: File $json_filename not exists!\n\n");
}

$json = file_get_contents($json_filename);
$array = json_decode($json, true);

$csv_filename = replace_extension($json_filename, "csv");

$f = fopen($csv_filename, 'w');

$header_line_array = ['Task ID', 'Created At', 'Completed At', 'Last Modified', 'Name', 'Assignee', 'Due Date', 'Tags', 'Notes', 'Projects', 'Parent Task'];
fputcsv($f, $header_line_array);

foreach ($array["data"] as $row)
{
    $csv_line = [
        $row['id'],
        date_short_format($row['created_at']),
        date_short_format($row['completed_at']),
        date_short_format($row['modified_at']),
        $row['name'],
        $row['assignee']['name'],
        date_short_format($row['due_on']),
        tags_to_string($row['tags']),
        $row['notes'],
        $row['projects'][0]['name'],
        null,
    ];

    echo "\n> ".$row['id'].' '.$row['name'];
	fputcsv($f, $csv_line);
}

fclose($f);

exit("\n\nConvert Asana`s JSON to CSV completed!\n\n");

function tags_to_string($tags)
{
    if (count($tags)) {
        $new_tags = [];
        foreach ($tags as $tag) {
            $new_tags[] = $tag['name'];
        }
        return implode(",", $new_tags);
    }
    return null;
}

function date_short_format($date_string)
{
    if ($date_string === null) {
        return null;
    }

    $date = date_create($date_string);
    return date_format($date, 'Y-m-d');
}

function replace_extension($filename, $new_extension) {
    return preg_replace('/\..+$/', '.' . $new_extension, $filename);
}
