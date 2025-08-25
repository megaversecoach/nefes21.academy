<?php

if (!defined('ABSPATH')) {
	exit();
};

class KommoFlashFunctionsDb
{
    public static function update(array $data, array $where)
    {
        global $wpdb;

        return $wpdb->update($wpdb->prefix . KOMMOFLASH_DB_TABLE, $data, $where);
    }

    public static function select($select, $whereItems)
    {
        global $wpdb;

        $whereItemsOrigin = $whereItems;

        $selectItems = explode(', ', $select);
        if (!is_array($whereItemsOrigin)) {
            $whereItems = [$whereItems];
        }
        $table = $wpdb->prefix . KOMMOFLASH_DB_TABLE;
        $table = (string)$table;
        if (count($selectItems) > 1 ) {
            $selectItem1 = $selectItems[0];
            $selectItem2 = $selectItems[1];
            $sql = call_user_func_array(
                array( $wpdb, 'prepare' ),
                array_merge(
                    array(
                        "
                        SELECT %i, %i
                        FROM %i
                        WHERE `option_name`
                        IN ( " . join( ', ', array_fill( 0, count( $whereItems ), '%s' ) ) . " )
                        "
                    ),
                    array_merge([$selectItem1, $selectItem2, $table], $whereItems)
                )
            );
            $resultsDb = $wpdb->get_results( $sql, 'ARRAY_A' );
        } else {
            $selectItem1 = $selectItems[0];
            $whereItem1 = $whereItems[0];
            $resultsDb = $wpdb->get_results(
                $wpdb->prepare(
                    // phpcs:ignore WordPress.DB.PreparedSQL.NotPrepared
                    'SELECT %i FROM %i WHERE option_name = %s;',
                    array( $selectItem1, $table, $whereItem1)
                ),
                'ARRAY_A'
            );
        }

        if (!is_array($whereItemsOrigin)) {
            try {
                $value = $resultsDb[0]['option_value'];
            } catch (\Exception|\Error $e) {
                $value = null;
            }

            $result = $value;
        } else {
            $results = [];

            foreach ($resultsDb as $item) {
                $results[$item['option_name']] = $item['option_value'];
            }

            $result = $results;
        }

        return $result;
    }
}
