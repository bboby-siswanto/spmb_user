<?php 
class ApiConfig{
    public function get_message($s_code, $mba_data_message = false)
    {
        $a_message = array(
            '0' => 'Success',
            '998' => 'Wrong Token',
            '003' => 'Required Field',
            '004' => 'Not Allowed',
            '005' => 'Invalid Data',
            '099' => 'Timeout Submit Data'
        );

        if (array_key_exists($s_code, $a_message)) {
            return ['code' => $s_code, 'message' => $a_message[$s_code], 'data' => $mba_data_message];
        }else{
            return ['code' => '099', 'message' => $a_message['099'], 'data' => false];
        }
    }
}