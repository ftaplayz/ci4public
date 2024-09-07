<?php
/**
 * Sets a table header and rows with an associative array and the array of objects to iterate, can pass a header key with a custom format like 'This is my id: {{property}}'
 * @param array $header Associative array, the key is the name of the property in the object and the value is the header on the table
 * @param array $iterate Array of objects to iterate
 * @return \CodeIgniter\View\Table Table ready to generate
 */
function assocToTable(array $header, array $iterate): ?\CodeIgniter\View\Table{
    function getProp(object $obj, array $properties){
        $size = count($properties);
        if($size > 1){
            $arr = array_shift($properties);
            return getProp($obj->{$arr}, $properties);
        }
        return $obj->{$properties[0]};
    }

    if(empty($iterate) || empty($header))
        return null;
    $table = new \CodeIgniter\View\Table();
    $table->setHeading($header)->setSyncRowsWithHeading(true);
    $keys = array_keys($header);
    for($iterator = new \App\Core\Iterator($iterate);!$iterator->isDone();$iterator->next()){
        if(empty($iterator->current()))
            continue;
        $data = [];
        $txt = null;
        for($keysHead = new \App\Core\Iterator($keys);!$keysHead->isDone();$keysHead->next()){
            $output_array = null;
            $data[$keysHead->current()] = preg_match('/([^{]+){{([^}]+)}}(.+)/', $keysHead->current(), $output_array)?preg_replace('/([^{]+){{([^}]+)}}(.+)/', '${1}'.getProp($iterator->current(), explode('->', $output_array[2])).'${3}', $keysHead->current()):getProp($iterator->current(), explode('->', $keysHead->current()));
            /*$arr2 = [];
            preg_match_all('/\[\[([#|\/])([^\[\]]+)]]/', $keysHead->current(), $arr2);
            if(count($arr2)%2!=0)
                continue;*/
            /*if(preg_match('/([^{]+){{([^}]+)}}(.+)/', $keysHead->current(), $output_array)){
                $prop = (string)getProp($iterator->current(), explode('->', $output_array[2]));
                $data[$keysHead->current()] = preg_replace('/([^{]+){{([^}]+)}}(.+)/', '${1}'.$prop.'${3}', $keysHead->current());
            }else
                $data[$keysHead->current()] = getProp($iterator->current(), explode('->', $keysHead->current()));*/
            /*$prop = getProp($iterator->current(), explode('->', $keysHead->current()));
        $data[$keysHead->current()] = preg_replace('/([^{]+){{([^}]+)}}(.+)/', '$1' . getProp($iterator->current(), explode('->', $keysHead->current())) . '$3',);*/

            /*if( $work =preg_replace('/([^{]+){{([^}]+)}}(.+)/', '$1'.$data[$keysHead->current()].'$3'))
                $data[$keysHead->current()] = $work;*/
        }
        $table->addRow($data);
    }
    return $table;
}