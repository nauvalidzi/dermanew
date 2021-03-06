<?php

namespace PHPMaker2021\Dermateknonew;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for d_jatuhtempo
 */
class DJatuhtempo extends DbTable
{
    protected $SqlFrom = "";
    protected $SqlSelect = null;
    protected $SqlSelectList = null;
    protected $SqlWhere = "";
    protected $SqlGroupBy = "";
    protected $SqlHaving = "";
    protected $SqlOrderBy = "";
    public $UseSessionForListSql = true;

    // Column CSS classes
    public $LeftColumnClass = "col-sm-2 col-form-label ew-label";
    public $RightColumnClass = "col-sm-10";
    public $OffsetColumnClass = "col-sm-10 offset-sm-2";
    public $TableLeftColumnClass = "w-col-2";

    // Export
    public $ExportDoc;

    // Fields
    public $idpegawai;
    public $namapegawai;
    public $idcustomer;
    public $namacustomer;
    public $idinvoice;
    public $kodeinvoice;
    public $sisabayar;
    public $jatuhtempo;
    public $sisahari;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'd_jatuhtempo';
        $this->TableName = 'd_jatuhtempo';
        $this->TableType = 'VIEW';

        // Update Table
        $this->UpdateTable = "`d_jatuhtempo`";
        $this->Dbid = 'DB';
        $this->ExportAll = true;
        $this->ExportPageBreakCount = 0; // Page break per every n record (PDF only)
        $this->ExportPageOrientation = "portrait"; // Page orientation (PDF only)
        $this->ExportPageSize = "a4"; // Page size (PDF only)
        $this->ExportExcelPageOrientation = ""; // Page orientation (PhpSpreadsheet only)
        $this->ExportExcelPageSize = ""; // Page size (PhpSpreadsheet only)
        $this->ExportWordPageOrientation = "portrait"; // Page orientation (PHPWord only)
        $this->ExportWordColumnWidth = null; // Cell width (PHPWord only)
        $this->DetailAdd = false; // Allow detail add
        $this->DetailEdit = false; // Allow detail edit
        $this->DetailView = false; // Allow detail view
        $this->ShowMultipleDetails = false; // Show multiple details
        $this->GridAddRowCount = 2;
        $this->AllowAddDeleteRow = true; // Allow add/delete row
        $this->UserIDAllowSecurity = Config("DEFAULT_USER_ID_ALLOW_SECURITY"); // Default User ID allowed permissions
        $this->BasicSearch = new BasicSearch($this->TableVar);

        // idpegawai
        $this->idpegawai = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->idpegawai->IsAutoIncrement = true; // Autoincrement field
        $this->idpegawai->IsPrimaryKey = true; // Primary key field
        $this->idpegawai->Sortable = true; // Allow sort
        $this->idpegawai->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idpegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idpegawai->Param, "CustomMsg");
        $this->Fields['idpegawai'] = &$this->idpegawai;

        // namapegawai
        $this->namapegawai = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_namapegawai', 'namapegawai', '`namapegawai`', '`namapegawai`', 200, 123, -1, false, '`namapegawai`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namapegawai->Nullable = false; // NOT NULL field
        $this->namapegawai->Required = true; // Required field
        $this->namapegawai->Sortable = true; // Allow sort
        $this->namapegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namapegawai->Param, "CustomMsg");
        $this->Fields['namapegawai'] = &$this->namapegawai;

        // idcustomer
        $this->idcustomer = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->idcustomer->IsAutoIncrement = true; // Autoincrement field
        $this->idcustomer->IsPrimaryKey = true; // Primary key field
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // namacustomer
        $this->namacustomer = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_namacustomer', 'namacustomer', '`namacustomer`', '`namacustomer`', 200, 123, -1, false, '`namacustomer`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->namacustomer->Nullable = false; // NOT NULL field
        $this->namacustomer->Required = true; // Required field
        $this->namacustomer->Sortable = true; // Allow sort
        $this->namacustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->namacustomer->Param, "CustomMsg");
        $this->Fields['namacustomer'] = &$this->namacustomer;

        // idinvoice
        $this->idinvoice = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_idinvoice', 'idinvoice', '`idinvoice`', '`idinvoice`', 3, 11, -1, false, '`idinvoice`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->idinvoice->IsAutoIncrement = true; // Autoincrement field
        $this->idinvoice->IsPrimaryKey = true; // Primary key field
        $this->idinvoice->Sortable = true; // Allow sort
        $this->idinvoice->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idinvoice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idinvoice->Param, "CustomMsg");
        $this->Fields['idinvoice'] = &$this->idinvoice;

        // kodeinvoice
        $this->kodeinvoice = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_kodeinvoice', 'kodeinvoice', '`kodeinvoice`', '`kodeinvoice`', 200, 50, -1, false, '`kodeinvoice`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kodeinvoice->Nullable = false; // NOT NULL field
        $this->kodeinvoice->Required = true; // Required field
        $this->kodeinvoice->Sortable = true; // Allow sort
        $this->kodeinvoice->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kodeinvoice->Param, "CustomMsg");
        $this->Fields['kodeinvoice'] = &$this->kodeinvoice;

        // sisabayar
        $this->sisabayar = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_sisabayar', 'sisabayar', '`sisabayar`', '`sisabayar`', 20, 20, -1, false, '`sisabayar`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisabayar->Nullable = false; // NOT NULL field
        $this->sisabayar->Sortable = true; // Allow sort
        $this->sisabayar->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisabayar->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisabayar->Param, "CustomMsg");
        $this->Fields['sisabayar'] = &$this->sisabayar;

        // jatuhtempo
        $this->jatuhtempo = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_jatuhtempo', 'jatuhtempo', '`jatuhtempo`', CastDateFieldForLike("`jatuhtempo`", 0, "DB"), 135, 19, 0, false, '`jatuhtempo`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jatuhtempo->Sortable = true; // Allow sort
        $this->jatuhtempo->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->jatuhtempo->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jatuhtempo->Param, "CustomMsg");
        $this->Fields['jatuhtempo'] = &$this->jatuhtempo;

        // sisahari
        $this->sisahari = new DbField('d_jatuhtempo', 'd_jatuhtempo', 'x_sisahari', 'sisahari', '`sisahari`', '`sisahari`', 20, 7, -1, false, '`sisahari`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->sisahari->Sortable = true; // Allow sort
        $this->sisahari->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->sisahari->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sisahari->Param, "CustomMsg");
        $this->Fields['sisahari'] = &$this->sisahari;
    }

    // Field Visibility
    public function getFieldVisibility($fldParm)
    {
        global $Security;
        return $this->$fldParm->Visible; // Returns original value
    }

    // Set left column class (must be predefined col-*-* classes of Bootstrap grid system)
    public function setLeftColumnClass($class)
    {
        if (preg_match('/^col\-(\w+)\-(\d+)$/', $class, $match)) {
            $this->LeftColumnClass = $class . " col-form-label ew-label";
            $this->RightColumnClass = "col-" . $match[1] . "-" . strval(12 - (int)$match[2]);
            $this->OffsetColumnClass = $this->RightColumnClass . " " . str_replace("col-", "offset-", $class);
            $this->TableLeftColumnClass = preg_replace('/^col-\w+-(\d+)$/', "w-col-$1", $class); // Change to w-col-*
        }
    }

    // Multiple column sort
    public function updateSort(&$fld, $ctrl)
    {
        if ($this->CurrentOrder == $fld->Name) {
            $sortField = $fld->Expression;
            $lastSort = $fld->getSort();
            if (in_array($this->CurrentOrderType, ["ASC", "DESC", "NO"])) {
                $curSort = $this->CurrentOrderType;
            } else {
                $curSort = $lastSort;
            }
            $fld->setSort($curSort);
            $lastOrderBy = in_array($lastSort, ["ASC", "DESC"]) ? $sortField . " " . $lastSort : "";
            $curOrderBy = in_array($curSort, ["ASC", "DESC"]) ? $sortField . " " . $curSort : "";
            if ($ctrl) {
                $orderBy = $this->getSessionOrderBy();
                $arOrderBy = !empty($orderBy) ? explode(", ", $orderBy) : [];
                if ($lastOrderBy != "" && in_array($lastOrderBy, $arOrderBy)) {
                    foreach ($arOrderBy as $key => $val) {
                        if ($val == $lastOrderBy) {
                            if ($curOrderBy == "") {
                                unset($arOrderBy[$key]);
                            } else {
                                $arOrderBy[$key] = $curOrderBy;
                            }
                        }
                    }
                } elseif ($curOrderBy != "") {
                    $arOrderBy[] = $curOrderBy;
                }
                $orderBy = implode(", ", $arOrderBy);
                $this->setSessionOrderBy($orderBy); // Save to Session
            } else {
                $this->setSessionOrderBy($curOrderBy); // Save to Session
            }
        } else {
            if (!$ctrl) {
                $fld->setSort("");
            }
        }
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`d_jatuhtempo`";
    }

    public function sqlFrom() // For backward compatibility
    {
        return $this->getSqlFrom();
    }

    public function setSqlFrom($v)
    {
        $this->SqlFrom = $v;
    }

    public function getSqlSelect() // Select
    {
        return $this->SqlSelect ?? $this->getQueryBuilder()->select("*");
    }

    public function sqlSelect() // For backward compatibility
    {
        return $this->getSqlSelect();
    }

    public function setSqlSelect($v)
    {
        $this->SqlSelect = $v;
    }

    public function getSqlWhere() // Where
    {
        $where = ($this->SqlWhere != "") ? $this->SqlWhere : "";
        $this->DefaultFilter = "";
        AddFilter($where, $this->DefaultFilter);
        return $where;
    }

    public function sqlWhere() // For backward compatibility
    {
        return $this->getSqlWhere();
    }

    public function setSqlWhere($v)
    {
        $this->SqlWhere = $v;
    }

    public function getSqlGroupBy() // Group By
    {
        return ($this->SqlGroupBy != "") ? $this->SqlGroupBy : "";
    }

    public function sqlGroupBy() // For backward compatibility
    {
        return $this->getSqlGroupBy();
    }

    public function setSqlGroupBy($v)
    {
        $this->SqlGroupBy = $v;
    }

    public function getSqlHaving() // Having
    {
        return ($this->SqlHaving != "") ? $this->SqlHaving : "";
    }

    public function sqlHaving() // For backward compatibility
    {
        return $this->getSqlHaving();
    }

    public function setSqlHaving($v)
    {
        $this->SqlHaving = $v;
    }

    public function getSqlOrderBy() // Order By
    {
        return ($this->SqlOrderBy != "") ? $this->SqlOrderBy : $this->DefaultSort;
    }

    public function sqlOrderBy() // For backward compatibility
    {
        return $this->getSqlOrderBy();
    }

    public function setSqlOrderBy($v)
    {
        $this->SqlOrderBy = $v;
    }

    // Apply User ID filters
    public function applyUserIDFilters($filter)
    {
        return $filter;
    }

    // Check if User ID security allows view all
    public function userIDAllow($id = "")
    {
        $allow = $this->UserIDAllowSecurity;
        switch ($id) {
            case "add":
            case "copy":
            case "gridadd":
            case "register":
            case "addopt":
                return (($allow & 1) == 1);
            case "edit":
            case "gridedit":
            case "update":
            case "changepassword":
            case "resetpassword":
                return (($allow & 4) == 4);
            case "delete":
                return (($allow & 2) == 2);
            case "view":
                return (($allow & 32) == 32);
            case "search":
                return (($allow & 64) == 64);
            default:
                return (($allow & 8) == 8);
        }
    }

    /**
     * Get record count
     *
     * @param string|QueryBuilder $sql SQL or QueryBuilder
     * @param mixed $c Connection
     * @return int
     */
    public function getRecordCount($sql, $c = null)
    {
        $cnt = -1;
        $rs = null;
        if ($sql instanceof \Doctrine\DBAL\Query\QueryBuilder) { // Query builder
            $sqlwrk = clone $sql;
            $sqlwrk = $sqlwrk->resetQueryPart("orderBy")->getSQL();
        } else {
            $sqlwrk = $sql;
        }
        $pattern = '/^SELECT\s([\s\S]+)\sFROM\s/i';
        // Skip Custom View / SubQuery / SELECT DISTINCT / ORDER BY
        if (
            ($this->TableType == 'TABLE' || $this->TableType == 'VIEW' || $this->TableType == 'LINKTABLE') &&
            preg_match($pattern, $sqlwrk) && !preg_match('/\(\s*(SELECT[^)]+)\)/i', $sqlwrk) &&
            !preg_match('/^\s*select\s+distinct\s+/i', $sqlwrk) && !preg_match('/\s+order\s+by\s+/i', $sqlwrk)
        ) {
            $sqlwrk = "SELECT COUNT(*) FROM " . preg_replace($pattern, "", $sqlwrk);
        } else {
            $sqlwrk = "SELECT COUNT(*) FROM (" . $sqlwrk . ") COUNT_TABLE";
        }
        $conn = $c ?? $this->getConnection();
        $rs = $conn->executeQuery($sqlwrk);
        $cnt = $rs->fetchColumn();
        if ($cnt !== false) {
            return (int)$cnt;
        }

        // Unable to get count by SELECT COUNT(*), execute the SQL to get record count directly
        return ExecuteRecordCount($sql, $conn);
    }

    // Get SQL
    public function getSql($where, $orderBy = "")
    {
        return $this->buildSelectSql(
            $this->getSqlSelect(),
            $this->getSqlFrom(),
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $where,
            $orderBy
        )->getSQL();
    }

    // Table SQL
    public function getCurrentSql()
    {
        $filter = $this->CurrentFilter;
        $filter = $this->applyUserIDFilters($filter);
        $sort = $this->getSessionOrderBy();
        return $this->getSql($filter, $sort);
    }

    /**
     * Table SQL with List page filter
     *
     * @return QueryBuilder
     */
    public function getListSql()
    {
        $filter = $this->UseSessionForListSql ? $this->getSessionWhere() : "";
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->getSqlSelect();
        $from = $this->getSqlFrom();
        $sort = $this->UseSessionForListSql ? $this->getSessionOrderBy() : "";
        $this->Sort = $sort;
        return $this->buildSelectSql(
            $select,
            $from,
            $this->getSqlWhere(),
            $this->getSqlGroupBy(),
            $this->getSqlHaving(),
            $this->getSqlOrderBy(),
            $filter,
            $sort
        );
    }

    // Get ORDER BY clause
    public function getOrderBy()
    {
        $orderBy = $this->getSqlOrderBy();
        $sort = $this->getSessionOrderBy();
        if ($orderBy != "" && $sort != "") {
            $orderBy .= ", " . $sort;
        } elseif ($sort != "") {
            $orderBy = $sort;
        }
        return $orderBy;
    }

    // Get record count based on filter (for detail record count in master table pages)
    public function loadRecordCount($filter)
    {
        $origFilter = $this->CurrentFilter;
        $this->CurrentFilter = $filter;
        $this->recordsetSelecting($this->CurrentFilter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $this->CurrentFilter, "");
        $cnt = $this->getRecordCount($sql);
        $this->CurrentFilter = $origFilter;
        return $cnt;
    }

    // Get record count (for current List page)
    public function listRecordCount()
    {
        $filter = $this->getSessionWhere();
        AddFilter($filter, $this->CurrentFilter);
        $filter = $this->applyUserIDFilters($filter);
        $this->recordsetSelecting($filter);
        $select = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlSelect() : $this->getQueryBuilder()->select("*");
        $groupBy = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlGroupBy() : "";
        $having = $this->TableType == 'CUSTOMVIEW' ? $this->getSqlHaving() : "";
        $sql = $this->buildSelectSql($select, $this->getSqlFrom(), $this->getSqlWhere(), $groupBy, $having, "", $filter, "");
        $cnt = $this->getRecordCount($sql);
        return $cnt;
    }

    /**
     * INSERT statement
     *
     * @param mixed $rs
     * @return QueryBuilder
     */
    protected function insertSql(&$rs)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->insert($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->setValue($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        return $queryBuilder;
    }

    // Insert
    public function insert(&$rs)
    {
        $conn = $this->getConnection();
        $success = $this->insertSql($rs)->execute();
        if ($success) {
            // Get insert id if necessary
            $this->idpegawai->setDbValue($conn->lastInsertId());
            $rs['idpegawai'] = $this->idpegawai->DbValue;

            // Get insert id if necessary
            $this->idcustomer->setDbValue($conn->lastInsertId());
            $rs['idcustomer'] = $this->idcustomer->DbValue;

            // Get insert id if necessary
            $this->idinvoice->setDbValue($conn->lastInsertId());
            $rs['idinvoice'] = $this->idinvoice->DbValue;
        }
        return $success;
    }

    /**
     * UPDATE statement
     *
     * @param array $rs Data to be updated
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function updateSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->update($this->UpdateTable);
        foreach ($rs as $name => $value) {
            if (!isset($this->Fields[$name]) || $this->Fields[$name]->IsCustom || $this->Fields[$name]->IsAutoIncrement) {
                continue;
            }
            $type = GetParameterType($this->Fields[$name], $value, $this->Dbid);
            $queryBuilder->set($this->Fields[$name]->Expression, $queryBuilder->createPositionalParameter($value, $type));
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        AddFilter($filter, $where);
        if ($filter != "") {
            $queryBuilder->where($filter);
        }
        return $queryBuilder;
    }

    // Update
    public function update(&$rs, $where = "", $rsold = null, $curfilter = true)
    {
        // If no field is updated, execute may return 0. Treat as success
        $success = $this->updateSql($rs, $where, $curfilter)->execute();
        $success = ($success > 0) ? $success : true;
        return $success;
    }

    /**
     * DELETE statement
     *
     * @param array $rs Key values
     * @param string|array $where WHERE clause
     * @param string $curfilter Filter
     * @return QueryBuilder
     */
    protected function deleteSql(&$rs, $where = "", $curfilter = true)
    {
        $queryBuilder = $this->getQueryBuilder();
        $queryBuilder->delete($this->UpdateTable);
        if (is_array($where)) {
            $where = $this->arrayToFilter($where);
        }
        if ($rs) {
            if (array_key_exists('idpegawai', $rs)) {
                AddFilter($where, QuotedName('idpegawai', $this->Dbid) . '=' . QuotedValue($rs['idpegawai'], $this->idpegawai->DataType, $this->Dbid));
            }
            if (array_key_exists('idcustomer', $rs)) {
                AddFilter($where, QuotedName('idcustomer', $this->Dbid) . '=' . QuotedValue($rs['idcustomer'], $this->idcustomer->DataType, $this->Dbid));
            }
            if (array_key_exists('idinvoice', $rs)) {
                AddFilter($where, QuotedName('idinvoice', $this->Dbid) . '=' . QuotedValue($rs['idinvoice'], $this->idinvoice->DataType, $this->Dbid));
            }
        }
        $filter = ($curfilter) ? $this->CurrentFilter : "";
        AddFilter($filter, $where);
        return $queryBuilder->where($filter != "" ? $filter : "0=1");
    }

    // Delete
    public function delete(&$rs, $where = "", $curfilter = false)
    {
        $success = true;
        if ($success) {
            $success = $this->deleteSql($rs, $where, $curfilter)->execute();
        }
        return $success;
    }

    // Load DbValue from recordset or array
    protected function loadDbValues($row)
    {
        if (!is_array($row)) {
            return;
        }
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->namapegawai->DbValue = $row['namapegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->namacustomer->DbValue = $row['namacustomer'];
        $this->idinvoice->DbValue = $row['idinvoice'];
        $this->kodeinvoice->DbValue = $row['kodeinvoice'];
        $this->sisabayar->DbValue = $row['sisabayar'];
        $this->jatuhtempo->DbValue = $row['jatuhtempo'];
        $this->sisahari->DbValue = $row['sisahari'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`idpegawai` = @idpegawai@ AND `idcustomer` = @idcustomer@ AND `idinvoice` = @idinvoice@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->idpegawai->CurrentValue : $this->idpegawai->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->idcustomer->CurrentValue : $this->idcustomer->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        $val = $current ? $this->idinvoice->CurrentValue : $this->idinvoice->OldValue;
        if (EmptyValue($val)) {
            return "";
        } else {
            $keys[] = $val;
        }
        return implode(Config("COMPOSITE_KEY_SEPARATOR"), $keys);
    }

    // Set Key
    public function setKey($key, $current = false)
    {
        $this->OldKey = strval($key);
        $keys = explode(Config("COMPOSITE_KEY_SEPARATOR"), $this->OldKey);
        if (count($keys) == 3) {
            if ($current) {
                $this->idpegawai->CurrentValue = $keys[0];
            } else {
                $this->idpegawai->OldValue = $keys[0];
            }
            if ($current) {
                $this->idcustomer->CurrentValue = $keys[1];
            } else {
                $this->idcustomer->OldValue = $keys[1];
            }
            if ($current) {
                $this->idinvoice->CurrentValue = $keys[2];
            } else {
                $this->idinvoice->OldValue = $keys[2];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('idpegawai', $row) ? $row['idpegawai'] : null;
        } else {
            $val = $this->idpegawai->OldValue !== null ? $this->idpegawai->OldValue : $this->idpegawai->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idpegawai@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('idcustomer', $row) ? $row['idcustomer'] : null;
        } else {
            $val = $this->idcustomer->OldValue !== null ? $this->idcustomer->OldValue : $this->idcustomer->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idcustomer@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        if (is_array($row)) {
            $val = array_key_exists('idinvoice', $row) ? $row['idinvoice'] : null;
        } else {
            $val = $this->idinvoice->OldValue !== null ? $this->idinvoice->OldValue : $this->idinvoice->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@idinvoice@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
        }
        return $keyFilter;
    }

    // Return page URL
    public function getReturnUrl()
    {
        $referUrl = ReferUrl();
        $referPageName = ReferPageName();
        $name = PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL");
        // Get referer URL automatically
        if ($referUrl != "" && $referPageName != CurrentPageName() && $referPageName != "login") { // Referer not same page or login page
            $_SESSION[$name] = $referUrl; // Save to Session
        }
        return $_SESSION[$name] ?? GetUrl("DJatuhtempoList");
    }

    // Set return page URL
    public function setReturnUrl($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_RETURN_URL")] = $v;
    }

    // Get modal caption
    public function getModalCaption($pageName)
    {
        global $Language;
        if ($pageName == "DJatuhtempoView") {
            return $Language->phrase("View");
        } elseif ($pageName == "DJatuhtempoEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "DJatuhtempoAdd") {
            return $Language->phrase("Add");
        } else {
            return "";
        }
    }

    // API page name
    public function getApiPageName($action)
    {
        switch (strtolower($action)) {
            case Config("API_VIEW_ACTION"):
                return "DJatuhtempoView";
            case Config("API_ADD_ACTION"):
                return "DJatuhtempoAdd";
            case Config("API_EDIT_ACTION"):
                return "DJatuhtempoEdit";
            case Config("API_DELETE_ACTION"):
                return "DJatuhtempoDelete";
            case Config("API_LIST_ACTION"):
                return "DJatuhtempoList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "DJatuhtempoList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("DJatuhtempoView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("DJatuhtempoView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "DJatuhtempoAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "DJatuhtempoAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("DJatuhtempoEdit", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline edit URL
    public function getInlineEditUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=edit"));
        return $this->addMasterUrl($url);
    }

    // Copy URL
    public function getCopyUrl($parm = "")
    {
        $url = $this->keyUrl("DJatuhtempoAdd", $this->getUrlParm($parm));
        return $this->addMasterUrl($url);
    }

    // Inline copy URL
    public function getInlineCopyUrl()
    {
        $url = $this->keyUrl(CurrentPageName(), $this->getUrlParm("action=copy"));
        return $this->addMasterUrl($url);
    }

    // Delete URL
    public function getDeleteUrl()
    {
        return $this->keyUrl("DJatuhtempoDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "idpegawai:" . JsonEncode($this->idpegawai->CurrentValue, "number");
        $json .= ",idcustomer:" . JsonEncode($this->idcustomer->CurrentValue, "number");
        $json .= ",idinvoice:" . JsonEncode($this->idinvoice->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->idpegawai->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idpegawai->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->idcustomer->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idcustomer->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($this->idinvoice->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->idinvoice->CurrentValue);
        } else {
            return "javascript:ew.alert(ew.language.phrase('InvalidRecord'));";
        }
        if ($parm != "") {
            $url .= "?" . $parm;
        }
        return $url;
    }

    // Render sort
    public function renderSort($fld)
    {
        $classId = $fld->TableVar . "_" . $fld->Param;
        $scriptId = str_replace("%id%", $classId, "tpc_%id%");
        $scriptStart = $this->UseCustomTemplate ? "<template id=\"" . $scriptId . "\">" : "";
        $scriptEnd = $this->UseCustomTemplate ? "</template>" : "";
        $jsSort = " class=\"ew-pointer\" onclick=\"ew.sort(event, '" . $this->sortUrl($fld) . "', 2);\"";
        if ($this->sortUrl($fld) == "") {
            $html = <<<NOSORTHTML
{$scriptStart}<div class="ew-table-header-caption">{$fld->caption()}</div>{$scriptEnd}
NOSORTHTML;
        } else {
            if ($fld->getSort() == "ASC") {
                $sortIcon = '<i class="fas fa-sort-up"></i>';
            } elseif ($fld->getSort() == "DESC") {
                $sortIcon = '<i class="fas fa-sort-down"></i>';
            } else {
                $sortIcon = '';
            }
            $html = <<<SORTHTML
{$scriptStart}<div{$jsSort}><div class="ew-table-header-btn"><span class="ew-table-header-caption">{$fld->caption()}</span><span class="ew-table-header-sort">{$sortIcon}</span></div></div>{$scriptEnd}
SORTHTML;
        }
        return $html;
    }

    // Sort URL
    public function sortUrl($fld)
    {
        if (
            $this->CurrentAction || $this->isExport() ||
            in_array($fld->Type, [128, 204, 205])
        ) { // Unsortable data type
                return "";
        } elseif ($fld->Sortable) {
            $urlParm = $this->getUrlParm("order=" . urlencode($fld->Name) . "&amp;ordertype=" . $fld->getNextSort());
            return $this->addMasterUrl(CurrentPageName() . "?" . $urlParm);
        } else {
            return "";
        }
    }

    // Get record keys from Post/Get/Session
    public function getRecordKeys()
    {
        $arKeys = [];
        $arKey = [];
        if (Param("key_m") !== null) {
            $arKeys = Param("key_m");
            $cnt = count($arKeys);
            for ($i = 0; $i < $cnt; $i++) {
                $arKeys[$i] = explode(Config("COMPOSITE_KEY_SEPARATOR"), $arKeys[$i]);
            }
        } else {
            if (($keyValue = Param("idpegawai") ?? Route("idpegawai")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("idcustomer") ?? Route("idcustomer")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(1) ?? Route(3)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (($keyValue = Param("idinvoice") ?? Route("idinvoice")) !== null) {
                $arKey[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(2) ?? Route(4)) !== null)) {
                $arKey[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }
            if (is_array($arKeys)) {
                $arKeys[] = $arKey;
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_array($key) || count($key) != 3) {
                    continue; // Just skip so other keys will still work
                }
                if (!is_numeric($key[0])) { // idpegawai
                    continue;
                }
                if (!is_numeric($key[1])) { // idcustomer
                    continue;
                }
                if (!is_numeric($key[2])) { // idinvoice
                    continue;
                }
                $ar[] = $key;
            }
        }
        return $ar;
    }

    // Get filter from record keys
    public function getFilterFromRecordKeys($setCurrent = true)
    {
        $arKeys = $this->getRecordKeys();
        $keyFilter = "";
        foreach ($arKeys as $key) {
            if ($keyFilter != "") {
                $keyFilter .= " OR ";
            }
            if ($setCurrent) {
                $this->idpegawai->CurrentValue = $key[0];
            } else {
                $this->idpegawai->OldValue = $key[0];
            }
            if ($setCurrent) {
                $this->idcustomer->CurrentValue = $key[1];
            } else {
                $this->idcustomer->OldValue = $key[1];
            }
            if ($setCurrent) {
                $this->idinvoice->CurrentValue = $key[2];
            } else {
                $this->idinvoice->OldValue = $key[2];
            }
            $keyFilter .= "(" . $this->getRecordFilter() . ")";
        }
        return $keyFilter;
    }

    // Load recordset based on filter
    public function &loadRs($filter)
    {
        $sql = $this->getSql($filter); // Set up filter (WHERE Clause)
        $conn = $this->getConnection();
        $stmt = $conn->executeQuery($sql);
        return $stmt;
    }

    // Load row values from record
    public function loadListRowValues(&$rs)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            return;
        }
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->namapegawai->setDbValue($row['namapegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->namacustomer->setDbValue($row['namacustomer']);
        $this->idinvoice->setDbValue($row['idinvoice']);
        $this->kodeinvoice->setDbValue($row['kodeinvoice']);
        $this->sisabayar->setDbValue($row['sisabayar']);
        $this->jatuhtempo->setDbValue($row['jatuhtempo']);
        $this->sisahari->setDbValue($row['sisahari']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // idpegawai

        // namapegawai

        // idcustomer

        // namacustomer

        // idinvoice

        // kodeinvoice

        // sisabayar

        // jatuhtempo

        // sisahari

        // idpegawai
        $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
        $this->idpegawai->ViewCustomAttributes = "";

        // namapegawai
        $this->namapegawai->ViewValue = $this->namapegawai->CurrentValue;
        $this->namapegawai->ViewCustomAttributes = "";

        // idcustomer
        $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
        $this->idcustomer->ViewCustomAttributes = "";

        // namacustomer
        $this->namacustomer->ViewValue = $this->namacustomer->CurrentValue;
        $this->namacustomer->ViewCustomAttributes = "";

        // idinvoice
        $this->idinvoice->ViewValue = $this->idinvoice->CurrentValue;
        $this->idinvoice->ViewCustomAttributes = "";

        // kodeinvoice
        $this->kodeinvoice->ViewValue = $this->kodeinvoice->CurrentValue;
        $this->kodeinvoice->ViewCustomAttributes = "";

        // sisabayar
        $this->sisabayar->ViewValue = $this->sisabayar->CurrentValue;
        $this->sisabayar->ViewValue = FormatNumber($this->sisabayar->ViewValue, 0, -2, -2, -2);
        $this->sisabayar->ViewCustomAttributes = "";

        // jatuhtempo
        $this->jatuhtempo->ViewValue = $this->jatuhtempo->CurrentValue;
        $this->jatuhtempo->ViewValue = FormatDateTime($this->jatuhtempo->ViewValue, 0);
        $this->jatuhtempo->ViewCustomAttributes = "";

        // sisahari
        $this->sisahari->ViewValue = $this->sisahari->CurrentValue;
        $this->sisahari->ViewValue = FormatNumber($this->sisahari->ViewValue, 0, -2, -2, -2);
        $this->sisahari->ViewCustomAttributes = "";

        // idpegawai
        $this->idpegawai->LinkCustomAttributes = "";
        $this->idpegawai->HrefValue = "";
        $this->idpegawai->TooltipValue = "";

        // namapegawai
        $this->namapegawai->LinkCustomAttributes = "";
        $this->namapegawai->HrefValue = "";
        $this->namapegawai->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // namacustomer
        $this->namacustomer->LinkCustomAttributes = "";
        $this->namacustomer->HrefValue = "";
        $this->namacustomer->TooltipValue = "";

        // idinvoice
        $this->idinvoice->LinkCustomAttributes = "";
        $this->idinvoice->HrefValue = "";
        $this->idinvoice->TooltipValue = "";

        // kodeinvoice
        $this->kodeinvoice->LinkCustomAttributes = "";
        $this->kodeinvoice->HrefValue = "";
        $this->kodeinvoice->TooltipValue = "";

        // sisabayar
        $this->sisabayar->LinkCustomAttributes = "";
        $this->sisabayar->HrefValue = "";
        $this->sisabayar->TooltipValue = "";

        // jatuhtempo
        $this->jatuhtempo->LinkCustomAttributes = "";
        $this->jatuhtempo->HrefValue = "";
        $this->jatuhtempo->TooltipValue = "";

        // sisahari
        $this->sisahari->LinkCustomAttributes = "";
        $this->sisahari->HrefValue = "";
        $this->sisahari->TooltipValue = "";

        // Call Row Rendered event
        $this->rowRendered();

        // Save data for Custom Template
        $this->Rows[] = $this->customTemplateFieldValues();
    }

    // Render edit row values
    public function renderEditRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // idpegawai
        $this->idpegawai->EditAttrs["class"] = "form-control";
        $this->idpegawai->EditCustomAttributes = "";
        $this->idpegawai->EditValue = $this->idpegawai->CurrentValue;
        $this->idpegawai->ViewCustomAttributes = "";

        // namapegawai
        $this->namapegawai->EditAttrs["class"] = "form-control";
        $this->namapegawai->EditCustomAttributes = "";
        if (!$this->namapegawai->Raw) {
            $this->namapegawai->CurrentValue = HtmlDecode($this->namapegawai->CurrentValue);
        }
        $this->namapegawai->EditValue = $this->namapegawai->CurrentValue;
        $this->namapegawai->PlaceHolder = RemoveHtml($this->namapegawai->caption());

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        $this->idcustomer->EditValue = $this->idcustomer->CurrentValue;
        $this->idcustomer->ViewCustomAttributes = "";

        // namacustomer
        $this->namacustomer->EditAttrs["class"] = "form-control";
        $this->namacustomer->EditCustomAttributes = "";
        if (!$this->namacustomer->Raw) {
            $this->namacustomer->CurrentValue = HtmlDecode($this->namacustomer->CurrentValue);
        }
        $this->namacustomer->EditValue = $this->namacustomer->CurrentValue;
        $this->namacustomer->PlaceHolder = RemoveHtml($this->namacustomer->caption());

        // idinvoice
        $this->idinvoice->EditAttrs["class"] = "form-control";
        $this->idinvoice->EditCustomAttributes = "";
        $this->idinvoice->EditValue = $this->idinvoice->CurrentValue;
        $this->idinvoice->ViewCustomAttributes = "";

        // kodeinvoice
        $this->kodeinvoice->EditAttrs["class"] = "form-control";
        $this->kodeinvoice->EditCustomAttributes = "";
        if (!$this->kodeinvoice->Raw) {
            $this->kodeinvoice->CurrentValue = HtmlDecode($this->kodeinvoice->CurrentValue);
        }
        $this->kodeinvoice->EditValue = $this->kodeinvoice->CurrentValue;
        $this->kodeinvoice->PlaceHolder = RemoveHtml($this->kodeinvoice->caption());

        // sisabayar
        $this->sisabayar->EditAttrs["class"] = "form-control";
        $this->sisabayar->EditCustomAttributes = "";
        $this->sisabayar->EditValue = $this->sisabayar->CurrentValue;
        $this->sisabayar->PlaceHolder = RemoveHtml($this->sisabayar->caption());

        // jatuhtempo
        $this->jatuhtempo->EditAttrs["class"] = "form-control";
        $this->jatuhtempo->EditCustomAttributes = "";
        $this->jatuhtempo->EditValue = FormatDateTime($this->jatuhtempo->CurrentValue, 8);
        $this->jatuhtempo->PlaceHolder = RemoveHtml($this->jatuhtempo->caption());

        // sisahari
        $this->sisahari->EditAttrs["class"] = "form-control";
        $this->sisahari->EditCustomAttributes = "";
        $this->sisahari->EditValue = $this->sisahari->CurrentValue;
        $this->sisahari->PlaceHolder = RemoveHtml($this->sisahari->caption());

        // Call Row Rendered event
        $this->rowRendered();
    }

    // Aggregate list row values
    public function aggregateListRowValues()
    {
    }

    // Aggregate list row (for rendering)
    public function aggregateListRow()
    {
        // Call Row Rendered event
        $this->rowRendered();
    }

    // Export data in HTML/CSV/Word/Excel/Email/PDF format
    public function exportDocument($doc, $recordset, $startRec = 1, $stopRec = 1, $exportPageType = "")
    {
        if (!$recordset || !$doc) {
            return;
        }
        if (!$doc->ExportCustom) {
            // Write header
            $doc->exportTableHeader();
            if ($doc->Horizontal) { // Horizontal format, write header
                $doc->beginExportRow();
                if ($exportPageType == "view") {
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->namapegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->namacustomer);
                    $doc->exportCaption($this->idinvoice);
                    $doc->exportCaption($this->kodeinvoice);
                    $doc->exportCaption($this->sisabayar);
                    $doc->exportCaption($this->jatuhtempo);
                    $doc->exportCaption($this->sisahari);
                } else {
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->namapegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->namacustomer);
                    $doc->exportCaption($this->idinvoice);
                    $doc->exportCaption($this->kodeinvoice);
                    $doc->exportCaption($this->sisabayar);
                    $doc->exportCaption($this->jatuhtempo);
                    $doc->exportCaption($this->sisahari);
                }
                $doc->endExportRow();
            }
        }

        // Move to first record
        $recCnt = $startRec - 1;
        $stopRec = ($stopRec > 0) ? $stopRec : PHP_INT_MAX;
        while (!$recordset->EOF && $recCnt < $stopRec) {
            $row = $recordset->fields;
            $recCnt++;
            if ($recCnt >= $startRec) {
                $rowCnt = $recCnt - $startRec + 1;

                // Page break
                if ($this->ExportPageBreakCount > 0) {
                    if ($rowCnt > 1 && ($rowCnt - 1) % $this->ExportPageBreakCount == 0) {
                        $doc->exportPageBreak();
                    }
                }
                $this->loadListRowValues($row);

                // Render row
                $this->RowType = ROWTYPE_VIEW; // Render view
                $this->resetAttributes();
                $this->renderListRow();
                if (!$doc->ExportCustom) {
                    $doc->beginExportRow($rowCnt); // Allow CSS styles if enabled
                    if ($exportPageType == "view") {
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->namapegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->namacustomer);
                        $doc->exportField($this->idinvoice);
                        $doc->exportField($this->kodeinvoice);
                        $doc->exportField($this->sisabayar);
                        $doc->exportField($this->jatuhtempo);
                        $doc->exportField($this->sisahari);
                    } else {
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->namapegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->namacustomer);
                        $doc->exportField($this->idinvoice);
                        $doc->exportField($this->kodeinvoice);
                        $doc->exportField($this->sisabayar);
                        $doc->exportField($this->jatuhtempo);
                        $doc->exportField($this->sisahari);
                    }
                    $doc->endExportRow($rowCnt);
                }
            }

            // Call Row Export server event
            if ($doc->ExportCustom) {
                $this->rowExport($row);
            }
            $recordset->moveNext();
        }
        if (!$doc->ExportCustom) {
            $doc->exportTableFooter();
        }
    }

    // Get file data
    public function getFileData($fldparm, $key, $resize, $width = 0, $height = 0, $plugins = [])
    {
        // No binary fields
        return false;
    }

    // Table level events

    // Recordset Selecting event
    public function recordsetSelecting(&$filter)
    {
        // Enter your code here
    }

    // Recordset Selected event
    public function recordsetSelected(&$rs)
    {
        //Log("Recordset Selected");
    }

    // Recordset Search Validated event
    public function recordsetSearchValidated()
    {
        // Example:
        //$this->MyField1->AdvancedSearch->SearchValue = "your search criteria"; // Search value
    }

    // Recordset Searching event
    public function recordsetSearching(&$filter)
    {
        // Enter your code here
    }

    // Row_Selecting event
    public function rowSelecting(&$filter)
    {
        // Enter your code here
    }

    // Row Selected event
    public function rowSelected(&$rs)
    {
        //Log("Row Selected");
    }

    // Row Inserting event
    public function rowInserting($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Inserted event
    public function rowInserted($rsold, &$rsnew)
    {
        //Log("Row Inserted");
    }

    // Row Updating event
    public function rowUpdating($rsold, &$rsnew)
    {
        // Enter your code here
        // To cancel, set return value to false
        return true;
    }

    // Row Updated event
    public function rowUpdated($rsold, &$rsnew)
    {
        //Log("Row Updated");
    }

    // Row Update Conflict event
    public function rowUpdateConflict($rsold, &$rsnew)
    {
        // Enter your code here
        // To ignore conflict, set return value to false
        return true;
    }

    // Grid Inserting event
    public function gridInserting()
    {
        // Enter your code here
        // To reject grid insert, set return value to false
        return true;
    }

    // Grid Inserted event
    public function gridInserted($rsnew)
    {
        //Log("Grid Inserted");
    }

    // Grid Updating event
    public function gridUpdating($rsold)
    {
        // Enter your code here
        // To reject grid update, set return value to false
        return true;
    }

    // Grid Updated event
    public function gridUpdated($rsold, $rsnew)
    {
        //Log("Grid Updated");
    }

    // Row Deleting event
    public function rowDeleting(&$rs)
    {
        // Enter your code here
        // To cancel, set return value to False
        return true;
    }

    // Row Deleted event
    public function rowDeleted(&$rs)
    {
        //Log("Row Deleted");
    }

    // Email Sending event
    public function emailSending($email, &$args)
    {
        //var_dump($email); var_dump($args); exit();
        return true;
    }

    // Lookup Selecting event
    public function lookupSelecting($fld, &$filter)
    {
        //var_dump($fld->Name, $fld->Lookup, $filter); // Uncomment to view the filter
        // Enter your code here
    }

    // Row Rendering event
    public function rowRendering()
    {
        // Enter your code here
    }

    // Row Rendered event
    public function rowRendered()
    {
        // To view properties of field class, use:
        //var_dump($this-><FieldName>);
    }

    // User ID Filtering event
    public function userIdFiltering(&$filter)
    {
        // Enter your code here
    }
}
