<?php

class WPD_DB
{


    static function start_transaction()
    {
        global $wpdb;

        $wpdb->query('START TRANSACTION');
    }

    static function end_transaction($transaction_error = false)
    {
        global $wpdb;

        if (!$transaction_error) {
            $wpdb->query('COMMIT'); // commits all queries
        } else {
            $wpdb->query('ROLLBACK'); // rollbacks everything
        }
    }

    static function query($query)
    {
        global $wpdb;

        $result = $wpdb->query($query);

        return $result;
    }

    static function select($query, $format = ARRAY_A)
    {
        global $wpdb;

        // OBJECT – result will be output as an object.
        // ARRAY_A – result will be output as an associative array.
        // ARRAY_N – result will be output as a numerically indexed array.
        $result = $wpdb->get_results($query, $format);

        return $result;
    }

    static function insert($table, $data)
    {
        global $wpdb;

        $result = $wpdb->insert($table, $data);

        return $result;
    }

    static function update($table, $data, $where)
    {
        global $wpdb;

        $result = $wpdb->insert($table, $data, $where);

        return $result;
    }
}
