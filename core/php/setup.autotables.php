<?php
    $alm_table = new alm_tableTable();
    $alm_column = new alm_columnTable();
    $table_data = $alm_table->readData();

    if (!isset($output)) $output = '';

    foreach ($table_data as $table_datum) {
      $output .= "class " . $table_datum['idalm_table'] . "Table extends Table {\n";
      $output .= "  function ".$table_datum['idalm_table']."Table() {\n";
      $output .= "    \$this->Table('".$table_datum['idalm_table']."');\n";
      $hidden = ($table_datum['hidden'] == 't') ? 'true' : 'false';
      if ($hidden === 'true') $output .= "    \$this->hidden = ".$hidden.";\n";
      if (!empty($table_datum['parent'])) $output .= "    \$this->parent ='".$table_datum['parent']."';\n";
      if (!empty($table_datum['child'])) $output .= "    \$this->child ='".$table_datum['child']."';\n";
      if (!empty($table_datum['restrictby']))
        $output .= "    if (\$_SESSION['idalm_role'] !== 'full') \$this->filter = \"" . $table_datum['idalm_table'].'.'.$table_datum['restrictby'] . "='\".\$_SESSION['idalm_user'].\"'\";\n";
      $output .= "    \$this->title ='".$table_datum['alm_table']."';\n";
      if (!empty($table_datum['orden']))
        $output .= "    \$this->order ='".$table_datum['orden']."';\n";
      $data = $alm_column->readDataFilter("alm_column.idalm_table='".$table_datum['idalm_table']."'");
      if ($data)
      foreach ($data as $datum) {
        if ($datum['pk'] == 't') $datum['pk'] = 1;
        if ($datum['pk'] == 'f') $datum['pk'] = 0;
        if (empty($datum['fk'])) $datum['fk'] = 0;
        else $datum['fk'] = "'".$datum['fk']."'";
        $extra = array();
      #$search = ($table_datum['search'] == 't') ? 'true' : 'false';
      #if ($search === 'true') $output .= "    \$this->search = ".$search.";\n";
        if (!empty($datum['idalm_role'])) $extra[] = "'role'=>'".$datum['idalm_role']."'";
        if (!empty($datum['label_bool'])) $extra[] = "'label_bool'=>'".$datum['label_bool']."'";
        if (!empty($datum['automatic'])) $extra[] = "'automatic'=>'".$datum['automatic']."'";
        if (!empty($datum['range'])) $extra[] = "'range'=>'".$datum['range']."'";
        if (!empty($datum['sizes'])) $extra[] = "'sizes'=>'".$datum['sizes']."'";
        # FIXME: Mejor usar 1:Hola;2:Chao para list_values
        if (!empty($datum['list_values'])) $extra[] = "'list_values'=>array(".$datum['list_values'].")";
        if (!empty($datum['help'])) $extra[] = "'help'=>'".$datum['help']."'";
        if (!empty($datum['display'])) $extra[] = "'display'=>\"".$datum['display'].'"';
        if (!empty($datum['search']) && $datum['search'] != 'f') $extra[] = "'search'=>true";
        if (!empty($datum['cdn']) && $datum['cdn'] != 'f') $extra[] = "'cdn'=>true";
        $output .= "    \$this->addColumn('". $datum['idalm_column'] . "','" . $datum['type'] . "'," . $datum['size'] . "," . $datum['pk'] . "," .$datum['fk'] . ",'" . addslashes($datum['alm_column']) . "'";
        if (!empty($extra)) {
          $output .= "," . 'array(' . implode(',',$extra) . ')';
        }
        $output .= ");\n";
      }
      $output .= "  }\n}\n";
    }
    if ($autosave === true || (isset($_REQUEST['save']) && $_REQUEST['save'] == '1')) {
      if (!is_writable(ROOTDIR.'/classes/tables.class.php')) {
        $saved = false;
      } else {
        $today = date('YmdHis');
        copy(ROOTDIR.'/classes/tables.class.php', ROOTDIR.'/logs/tables.class.'.$today.'.php');
        $fp = fopen(ROOTDIR.'/classes/tables.class.php', 'w');
        fwrite($fp, "<?php\n$output");
        fclose($fp);
        $saved = true;
      }
    }
