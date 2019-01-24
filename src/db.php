<?php

function getMysqli(&$errors)
{
    $mysqli = mysqli_connect("db", "psw", "pws", "psw", 3306);

    if (!$mysqli) {
        $errors[] = sprintf(
            'Database error: %s %s',
            mysqli_connect_errno(),
            mysqli_connect_error()
        );

        return null;
    }

    return $mysqli;
}

function fetchRows($query)
{
    $rows = array();
    while($row = \mysqli_fetch_array($query)) {
        $rows[] = $row;
    }

    return $rows;
}


function getSelectQuery($mysqli) {
    return function($table, $fields = [], $where = []) use ($mysqli) {
        $queryString = sprintf(
            'SELECT %s FROM %s',
            count($fields) > 0 ? implode(',', $fields) : '*',
            $table
        );

        if (count($where) > 0) {
            $queryString = sprintf(
                '%s WHERE %s',
                $queryString,
                implode(" AND ", $where)
            );
        }

        $query = mysqli_query($mysqli, $queryString) or die("Invalid query: " . mysqli_connect_error());

        return fetchRows($query);
    };
}


function getInsertQuery($mysqli) {
    return function($table, $fieldValues) use ($mysqli) {
        $keys = array_keys($fieldValues);
        $values = array_values($fieldValues);
        $values = array_map(
            'quotemeta', $values
        );


        $queryState = mysqli_query($mysqli, sprintf(
            'INSERT INTO %s (%s) VALUES ("%s")',
            $table,
            implode(',', $keys),
            implode('","', $values)
        )) or die("Invalid query: " . mysqli_connect_error());

        return $queryState;
    };
}

function getUpdateQuery($mysqli)
{
    return function($table, $fieldValues, $where = []) use ($mysqli) {
        $values = array_values($fieldValues);
        $values = array_map(
            'quotemeta', $values
        );

        $queryString = sprintf(
            'UPDATE %s SET %s',
            $table,
            implode(',', $values)
        );

        if (count($where) > 0) {
            $queryString = sprintf(
                '%s WHERE %s',
                $queryString,
                implode(" AND ", $where)
            );
        }

        $queryState = mysqli_query($mysqli, $queryString) or die("Invalid query: " . mysqli_connect_error());

        return $queryState;
    };
}

function getPlainQuery($mysqli) {
    return function($query) use ($mysqli) {
        $queryState = mysqli_query($mysqli, $query) or die("Invalid query: " . mysqli_connect_error());

        return $queryState;
    };
}

function close($mysqli) {
    mysqli_close($mysqli);
}