# Asana JSON-dump to CSV converter

A simple PHP-converter that converts the JSON dump of service [Asana](https://asana.com/) to CSV.

## Why is it needed?

Asana has the ability to export tasks to JSON and CSV formats. Export to CSV, currently, has a limit of [500 lines](https://blog.asana.com/2014/09/export-to-csv/).

To build the majority of the retrospective reports, you need a complete dump of tasks, so the problem of completeness is solved in an obvious way - take the JSON dump (has no restrictions on the number of tasks) and convert it into a CSV format.

## How to run?

The converter is designed to work in command line mode (CLI-mode) and runs as follows:

```bash
php asana-json2csv.php /path/to/source/file.json
```

At the end of the script runing, the CSV dump will be saved to a file named ```file.csv``` in the same directory as the original JSON dump file of Asana.

## Notes

I did not use subtasks, therefore the field ```Parent Task``` in the final CSV-file will always be empty.

