<?php

namespace PHPMaker2021\Dermatekno;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_serahterima
 */
class NpdSerahterima extends DbTable
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
    public $id;
    public $idpegawai;
    public $idcustomer;
    public $created_at;
    public $readonly;
    public $tanggal_request;
    public $tanggal_serahterima;
    public $jenis_produk;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'npd_serahterima';
        $this->TableName = 'npd_serahterima';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_serahterima`";
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

        // id
        $this->id = new DbField('npd_serahterima', 'npd_serahterima', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->IsForeignKey = true; // Foreign key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idpegawai
        $this->idpegawai = new DbField('npd_serahterima', 'npd_serahterima', 'x_idpegawai', 'idpegawai', '`idpegawai`', '`idpegawai`', 3, 11, -1, false, '`idpegawai`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idpegawai->Nullable = false; // NOT NULL field
        $this->idpegawai->Required = true; // Required field
        $this->idpegawai->Sortable = true; // Allow sort
        $this->idpegawai->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idpegawai->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idpegawai->Lookup = new Lookup('idpegawai', 'pegawai', false, 'id', ["kode","nama","",""], [], ["x_idcustomer"], [], [], [], [], '', '');
                break;
            default:
                $this->idpegawai->Lookup = new Lookup('idpegawai', 'pegawai', false, 'id', ["kode","nama","",""], [], ["x_idcustomer"], [], [], [], [], '', '');
                break;
        }
        $this->idpegawai->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idpegawai->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idpegawai->Param, "CustomMsg");
        $this->Fields['idpegawai'] = &$this->idpegawai;

        // idcustomer
        $this->idcustomer = new DbField('npd_serahterima', 'npd_serahterima', 'x_idcustomer', 'idcustomer', '`idcustomer`', '`idcustomer`', 3, 11, -1, false, '`idcustomer`', false, false, false, 'FORMATTED TEXT', 'SELECT');
        $this->idcustomer->Nullable = false; // NOT NULL field
        $this->idcustomer->Required = true; // Required field
        $this->idcustomer->Sortable = true; // Allow sort
        $this->idcustomer->UsePleaseSelect = true; // Use PleaseSelect by default
        $this->idcustomer->PleaseSelectText = $Language->phrase("PleaseSelect"); // "PleaseSelect" text
        switch ($CurrentLanguage) {
            case "en":
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], ["x_idpegawai"], [], ["idpegawai"], ["x_idpegawai"], [], [], '', '');
                break;
            default:
                $this->idcustomer->Lookup = new Lookup('idcustomer', 'customer', false, 'id', ["kode","nama","",""], ["x_idpegawai"], [], ["idpegawai"], ["x_idpegawai"], [], [], '', '');
                break;
        }
        $this->idcustomer->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idcustomer->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idcustomer->Param, "CustomMsg");
        $this->Fields['idcustomer'] = &$this->idcustomer;

        // created_at
        $this->created_at = new DbField('npd_serahterima', 'npd_serahterima', 'x_created_at', 'created_at', '`created_at`', CastDateFieldForLike("`created_at`", 0, "DB"), 135, 19, 0, false, '`created_at`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_at->Nullable = false; // NOT NULL field
        $this->created_at->Required = true; // Required field
        $this->created_at->Sortable = true; // Allow sort
        $this->created_at->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->created_at->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_at->Param, "CustomMsg");
        $this->Fields['created_at'] = &$this->created_at;

        // readonly
        $this->readonly = new DbField('npd_serahterima', 'npd_serahterima', 'x_readonly', 'readonly', '`readonly`', '`readonly`', 16, 1, -1, false, '`readonly`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->readonly->Nullable = false; // NOT NULL field
        $this->readonly->Sortable = true; // Allow sort
        $this->readonly->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->readonly->Lookup = new Lookup('readonly', 'npd_serahterima', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->readonly->Lookup = new Lookup('readonly', 'npd_serahterima', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->readonly->OptionCount = 2;
        $this->readonly->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->readonly->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->readonly->Param, "CustomMsg");
        $this->Fields['readonly'] = &$this->readonly;

        // tanggal_request
        $this->tanggal_request = new DbField('npd_serahterima', 'npd_serahterima', 'x_tanggal_request', 'tanggal_request', '`tanggal_request`', CastDateFieldForLike("`tanggal_request`", 0, "DB"), 135, 19, 0, false, '`tanggal_request`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_request->Nullable = false; // NOT NULL field
        $this->tanggal_request->Required = true; // Required field
        $this->tanggal_request->Sortable = true; // Allow sort
        $this->tanggal_request->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_request->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_request->Param, "CustomMsg");
        $this->Fields['tanggal_request'] = &$this->tanggal_request;

        // tanggal_serahterima
        $this->tanggal_serahterima = new DbField('npd_serahterima', 'npd_serahterima', 'x_tanggal_serahterima', 'tanggal_serahterima', '`tanggal_serahterima`', CastDateFieldForLike("`tanggal_serahterima`", 0, "DB"), 135, 19, 0, false, '`tanggal_serahterima`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal_serahterima->Nullable = false; // NOT NULL field
        $this->tanggal_serahterima->Required = true; // Required field
        $this->tanggal_serahterima->Sortable = true; // Allow sort
        $this->tanggal_serahterima->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal_serahterima->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal_serahterima->Param, "CustomMsg");
        $this->Fields['tanggal_serahterima'] = &$this->tanggal_serahterima;

        // jenis_produk
        $this->jenis_produk = new DbField('npd_serahterima', 'npd_serahterima', 'x_jenis_produk', 'jenis_produk', '`jenis_produk`', '`jenis_produk`', 200, 50, -1, false, '`jenis_produk`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->jenis_produk->Nullable = false; // NOT NULL field
        $this->jenis_produk->Required = true; // Required field
        $this->jenis_produk->Sortable = true; // Allow sort
        $this->jenis_produk->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->jenis_produk->Param, "CustomMsg");
        $this->Fields['jenis_produk'] = &$this->jenis_produk;
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

    // Current detail table name
    public function getCurrentDetailTable()
    {
        return Session(PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE"));
    }

    public function setCurrentDetailTable($v)
    {
        $_SESSION[PROJECT_NAME . "_" . $this->TableVar . "_" . Config("TABLE_DETAIL_TABLE")] = $v;
    }

    // Get detail url
    public function getDetailUrl()
    {
        // Detail url
        $detailUrl = "";
        if ($this->getCurrentDetailTable() == "npd_sample") {
            $detailUrl = Container("npd_sample")->getListUrl() . "?" . Config("TABLE_SHOW_MASTER") . "=" . $this->TableVar;
            $detailUrl .= "&" . GetForeignKeyUrl("fk_id", $this->id->CurrentValue);
        }
        if ($detailUrl == "") {
            $detailUrl = "NpdSerahterimaList";
        }
        return $detailUrl;
    }

    // Table level SQL
    public function getSqlFrom() // From
    {
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_serahterima`";
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
            $this->id->setDbValue($conn->lastInsertId());
            $rs['id'] = $this->id->DbValue;
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
        // Cascade Update detail table 'npd_sample'
        $cascadeUpdate = false;
        $rscascade = [];
        if ($rsold && (isset($rs['id']) && $rsold['id'] != $rs['id'])) { // Update detail field 'idserahterima'
            $cascadeUpdate = true;
            $rscascade['idserahterima'] = $rs['id'];
        }
        if ($cascadeUpdate) {
            $rswrk = Container("npd_sample")->loadRs("`idserahterima` = " . QuotedValue($rsold['id'], DATATYPE_NUMBER, 'DB'))->fetchAll(\PDO::FETCH_ASSOC);
            foreach ($rswrk as $rsdtlold) {
                $rskey = [];
                $fldname = 'id';
                $rskey[$fldname] = $rsdtlold[$fldname];
                $rsdtlnew = array_merge($rsdtlold, $rscascade);
                // Call Row_Updating event
                $success = Container("npd_sample")->rowUpdating($rsdtlold, $rsdtlnew);
                if ($success) {
                    $success = Container("npd_sample")->update($rscascade, $rskey, $rsdtlold);
                }
                if (!$success) {
                    return false;
                }
                // Call Row_Updated event
                Container("npd_sample")->rowUpdated($rsdtlold, $rsdtlnew);
            }
        }

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
            if (array_key_exists('id', $rs)) {
                AddFilter($where, QuotedName('id', $this->Dbid) . '=' . QuotedValue($rs['id'], $this->id->DataType, $this->Dbid));
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

        // Cascade delete detail table 'npd_sample'
        $dtlrows = Container("npd_sample")->loadRs("`idserahterima` = " . QuotedValue($rs['id'], DATATYPE_NUMBER, "DB"))->fetchAll(\PDO::FETCH_ASSOC);
        // Call Row Deleting event
        foreach ($dtlrows as $dtlrow) {
            $success = Container("npd_sample")->rowDeleting($dtlrow);
            if (!$success) {
                break;
            }
        }
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                $success = Container("npd_sample")->delete($dtlrow); // Delete
                if (!$success) {
                    break;
                }
            }
        }
        // Call Row Deleted event
        if ($success) {
            foreach ($dtlrows as $dtlrow) {
                Container("npd_sample")->rowDeleted($dtlrow);
            }
        }
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
        $this->id->DbValue = $row['id'];
        $this->idpegawai->DbValue = $row['idpegawai'];
        $this->idcustomer->DbValue = $row['idcustomer'];
        $this->created_at->DbValue = $row['created_at'];
        $this->readonly->DbValue = $row['readonly'];
        $this->tanggal_request->DbValue = $row['tanggal_request'];
        $this->tanggal_serahterima->DbValue = $row['tanggal_serahterima'];
        $this->jenis_produk->DbValue = $row['jenis_produk'];
    }

    // Delete uploaded files
    public function deleteUploadedFiles($row)
    {
        $this->loadDbValues($row);
    }

    // Record filter WHERE clause
    protected function sqlKeyFilter()
    {
        return "`id` = @id@";
    }

    // Get Key
    public function getKey($current = false)
    {
        $keys = [];
        $val = $current ? $this->id->CurrentValue : $this->id->OldValue;
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
        if (count($keys) == 1) {
            if ($current) {
                $this->id->CurrentValue = $keys[0];
            } else {
                $this->id->OldValue = $keys[0];
            }
        }
    }

    // Get record filter
    public function getRecordFilter($row = null)
    {
        $keyFilter = $this->sqlKeyFilter();
        if (is_array($row)) {
            $val = array_key_exists('id', $row) ? $row['id'] : null;
        } else {
            $val = $this->id->OldValue !== null ? $this->id->OldValue : $this->id->CurrentValue;
        }
        if (!is_numeric($val)) {
            return "0=1"; // Invalid key
        }
        if ($val === null) {
            return "0=1"; // Invalid key
        } else {
            $keyFilter = str_replace("@id@", AdjustSql($val, $this->Dbid), $keyFilter); // Replace key value
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
        return $_SESSION[$name] ?? GetUrl("NpdSerahterimaList");
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
        if ($pageName == "NpdSerahterimaView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdSerahterimaEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdSerahterimaAdd") {
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
                return "NpdSerahterimaView";
            case Config("API_ADD_ACTION"):
                return "NpdSerahterimaAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdSerahterimaEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdSerahterimaDelete";
            case Config("API_LIST_ACTION"):
                return "NpdSerahterimaList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdSerahterimaList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdSerahterimaView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdSerahterimaView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdSerahterimaAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdSerahterimaAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdSerahterimaEdit", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdSerahterimaEdit", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        if ($parm != "") {
            $url = $this->keyUrl("NpdSerahterimaAdd", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdSerahterimaAdd", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
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
        return $this->keyUrl("NpdSerahterimaDelete", $this->getUrlParm());
    }

    // Add master url
    public function addMasterUrl($url)
    {
        return $url;
    }

    public function keyToJson($htmlEncode = false)
    {
        $json = "";
        $json .= "id:" . JsonEncode($this->id->CurrentValue, "number");
        $json = "{" . $json . "}";
        if ($htmlEncode) {
            $json = HtmlEncode($json);
        }
        return $json;
    }

    // Add key value to URL
    public function keyUrl($url, $parm = "")
    {
        if ($this->id->CurrentValue !== null) {
            $url .= "/" . rawurlencode($this->id->CurrentValue);
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
        } else {
            if (($keyValue = Param("id") ?? Route("id")) !== null) {
                $arKeys[] = $keyValue;
            } elseif (IsApi() && (($keyValue = Key(0) ?? Route(2)) !== null)) {
                $arKeys[] = $keyValue;
            } else {
                $arKeys = null; // Do not setup
            }

            //return $arKeys; // Do not return yet, so the values will also be checked by the following code
        }
        // Check keys
        $ar = [];
        if (is_array($arKeys)) {
            foreach ($arKeys as $key) {
                if (!is_numeric($key)) {
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
                $this->id->CurrentValue = $key;
            } else {
                $this->id->OldValue = $key;
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
        $this->id->setDbValue($row['id']);
        $this->idpegawai->setDbValue($row['idpegawai']);
        $this->idcustomer->setDbValue($row['idcustomer']);
        $this->created_at->setDbValue($row['created_at']);
        $this->readonly->setDbValue($row['readonly']);
        $this->tanggal_request->setDbValue($row['tanggal_request']);
        $this->tanggal_serahterima->setDbValue($row['tanggal_serahterima']);
        $this->jenis_produk->setDbValue($row['jenis_produk']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // idpegawai

        // idcustomer

        // created_at

        // readonly

        // tanggal_request

        // tanggal_serahterima

        // jenis_produk

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idpegawai
        $curVal = trim(strval($this->idpegawai->CurrentValue));
        if ($curVal != "") {
            $this->idpegawai->ViewValue = $this->idpegawai->lookupCacheOption($curVal);
            if ($this->idpegawai->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idpegawai->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idpegawai->Lookup->renderViewRow($rswrk[0]);
                    $this->idpegawai->ViewValue = $this->idpegawai->displayValue($arwrk);
                } else {
                    $this->idpegawai->ViewValue = $this->idpegawai->CurrentValue;
                }
            }
        } else {
            $this->idpegawai->ViewValue = null;
        }
        $this->idpegawai->ViewCustomAttributes = "";

        // idcustomer
        $curVal = trim(strval($this->idcustomer->CurrentValue));
        if ($curVal != "") {
            $this->idcustomer->ViewValue = $this->idcustomer->lookupCacheOption($curVal);
            if ($this->idcustomer->ViewValue === null) { // Lookup from database
                $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                $sqlWrk = $this->idcustomer->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                $ari = count($rswrk);
                if ($ari > 0) { // Lookup values found
                    $arwrk = $this->idcustomer->Lookup->renderViewRow($rswrk[0]);
                    $this->idcustomer->ViewValue = $this->idcustomer->displayValue($arwrk);
                } else {
                    $this->idcustomer->ViewValue = $this->idcustomer->CurrentValue;
                }
            }
        } else {
            $this->idcustomer->ViewValue = null;
        }
        $this->idcustomer->ViewCustomAttributes = "";

        // created_at
        $this->created_at->ViewValue = $this->created_at->CurrentValue;
        $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
        $this->created_at->ViewCustomAttributes = "";

        // readonly
        if (ConvertToBool($this->readonly->CurrentValue)) {
            $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
        } else {
            $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
        }
        $this->readonly->ViewCustomAttributes = "";

        // tanggal_request
        $this->tanggal_request->ViewValue = $this->tanggal_request->CurrentValue;
        $this->tanggal_request->ViewValue = FormatDateTime($this->tanggal_request->ViewValue, 0);
        $this->tanggal_request->ViewCustomAttributes = "";

        // tanggal_serahterima
        $this->tanggal_serahterima->ViewValue = $this->tanggal_serahterima->CurrentValue;
        $this->tanggal_serahterima->ViewValue = FormatDateTime($this->tanggal_serahterima->ViewValue, 0);
        $this->tanggal_serahterima->ViewCustomAttributes = "";

        // jenis_produk
        $this->jenis_produk->ViewValue = $this->jenis_produk->CurrentValue;
        $this->jenis_produk->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idpegawai
        $this->idpegawai->LinkCustomAttributes = "";
        $this->idpegawai->HrefValue = "";
        $this->idpegawai->TooltipValue = "";

        // idcustomer
        $this->idcustomer->LinkCustomAttributes = "";
        $this->idcustomer->HrefValue = "";
        $this->idcustomer->TooltipValue = "";

        // created_at
        $this->created_at->LinkCustomAttributes = "";
        $this->created_at->HrefValue = "";
        $this->created_at->TooltipValue = "";

        // readonly
        $this->readonly->LinkCustomAttributes = "";
        $this->readonly->HrefValue = "";
        $this->readonly->TooltipValue = "";

        // tanggal_request
        $this->tanggal_request->LinkCustomAttributes = "";
        $this->tanggal_request->HrefValue = "";
        $this->tanggal_request->TooltipValue = "";

        // tanggal_serahterima
        $this->tanggal_serahterima->LinkCustomAttributes = "";
        $this->tanggal_serahterima->HrefValue = "";
        $this->tanggal_serahterima->TooltipValue = "";

        // jenis_produk
        $this->jenis_produk->LinkCustomAttributes = "";
        $this->jenis_produk->HrefValue = "";
        $this->jenis_produk->TooltipValue = "";

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

        // id
        $this->id->EditAttrs["class"] = "form-control";
        $this->id->EditCustomAttributes = "";
        $this->id->EditValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idpegawai
        $this->idpegawai->EditAttrs["class"] = "form-control";
        $this->idpegawai->EditCustomAttributes = "";
        $this->idpegawai->PlaceHolder = RemoveHtml($this->idpegawai->caption());

        // idcustomer
        $this->idcustomer->EditAttrs["class"] = "form-control";
        $this->idcustomer->EditCustomAttributes = "";
        $this->idcustomer->PlaceHolder = RemoveHtml($this->idcustomer->caption());

        // created_at
        $this->created_at->EditAttrs["class"] = "form-control";
        $this->created_at->EditCustomAttributes = "";
        $this->created_at->EditValue = FormatDateTime($this->created_at->CurrentValue, 8);
        $this->created_at->PlaceHolder = RemoveHtml($this->created_at->caption());

        // readonly
        $this->readonly->EditCustomAttributes = "";
        $this->readonly->EditValue = $this->readonly->options(false);
        $this->readonly->PlaceHolder = RemoveHtml($this->readonly->caption());

        // tanggal_request
        $this->tanggal_request->EditAttrs["class"] = "form-control";
        $this->tanggal_request->EditCustomAttributes = "";
        $this->tanggal_request->EditValue = FormatDateTime($this->tanggal_request->CurrentValue, 8);
        $this->tanggal_request->PlaceHolder = RemoveHtml($this->tanggal_request->caption());

        // tanggal_serahterima
        $this->tanggal_serahterima->EditAttrs["class"] = "form-control";
        $this->tanggal_serahterima->EditCustomAttributes = "";
        $this->tanggal_serahterima->EditValue = FormatDateTime($this->tanggal_serahterima->CurrentValue, 8);
        $this->tanggal_serahterima->PlaceHolder = RemoveHtml($this->tanggal_serahterima->caption());

        // jenis_produk
        $this->jenis_produk->EditAttrs["class"] = "form-control";
        $this->jenis_produk->EditCustomAttributes = "";
        if (!$this->jenis_produk->Raw) {
            $this->jenis_produk->CurrentValue = HtmlDecode($this->jenis_produk->CurrentValue);
        }
        $this->jenis_produk->EditValue = $this->jenis_produk->CurrentValue;
        $this->jenis_produk->PlaceHolder = RemoveHtml($this->jenis_produk->caption());

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
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->tanggal_request);
                    $doc->exportCaption($this->tanggal_serahterima);
                    $doc->exportCaption($this->jenis_produk);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idpegawai);
                    $doc->exportCaption($this->idcustomer);
                    $doc->exportCaption($this->created_at);
                    $doc->exportCaption($this->readonly);
                    $doc->exportCaption($this->tanggal_request);
                    $doc->exportCaption($this->tanggal_serahterima);
                    $doc->exportCaption($this->jenis_produk);
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
                        $doc->exportField($this->id);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->tanggal_request);
                        $doc->exportField($this->tanggal_serahterima);
                        $doc->exportField($this->jenis_produk);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idpegawai);
                        $doc->exportField($this->idcustomer);
                        $doc->exportField($this->created_at);
                        $doc->exportField($this->readonly);
                        $doc->exportField($this->tanggal_request);
                        $doc->exportField($this->tanggal_serahterima);
                        $doc->exportField($this->jenis_produk);
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
