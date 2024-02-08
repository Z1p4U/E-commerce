<?php

namespace App\Traits;

trait ExportAudit
{

    /* Payload Handler */
    protected static function payload($payload): array
    {
        return [
            'columns' => explode(',', $payload["columns"]),
            'auditColumns' => explode(',', $payload["audit_columns"]),
            'extendColumns' => explode(',', $payload["extend_columns"]),
        ];
    }

    /* Export Header */
    protected static function headingColumns($payload): array
    {
        $columnTypes = self::payload($payload);

        return [
            ...$columnTypes["columns"],
            ...$columnTypes["auditColumns"],
            ...$columnTypes["extendColumns"],
        ];
    }

    /* Fetch Records With Selected Columns */
    protected static function selectedColumns($payload, $foreignKeys = []): array
    {
        $columnTypes = self::payload($payload);

        return [
            'select' => [
                ...$columnTypes["columns"],
                ...$columnTypes["auditColumns"],
                ...$foreignKeys
            ],
            'extend' => $columnTypes['extendColumns'],
        ];
    }

    protected static function sortColumns($row, $columns)
    {
        foreach ($columns as $column) {
            $resultRows[$column] = $row[$column];
        }
        info($resultRows);
        return $resultRows;
    }

    protected static function unSetColumns($row, array $columns)
    {
        collect($columns)->map(function ($column) use ($row) {
            unset($row[$column]);
            return $column;
        });
        return $row;
    }
}
