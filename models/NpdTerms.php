<?php

namespace PHPMaker2021\Dermateknonew;

use Doctrine\DBAL\ParameterType;

/**
 * Table class for npd_terms
 */
class NpdTerms extends DbTable
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
    public $idnpd;
    public $status;
    public $tglsubmit;
    public $sifatorder;
    public $ukuranutama;
    public $utamahargaisipcs;
    public $utamahargaprimerpcs;
    public $utamahargasekunderpcs;
    public $utamahargalabelpcs;
    public $utamahargatotalpcs;
    public $utamahargaisiorder;
    public $utamahargaprimerorder;
    public $utamahargasekunderorder;
    public $utamahargalabelorder;
    public $utamahargatotalorder;
    public $ukuranlain;
    public $lainhargaisipcs;
    public $lainhargaprimerpcs;
    public $lainhargasekunderpcs;
    public $lainhargalabelpcs;
    public $lainhargatotalpcs;
    public $lainhargaisiorder;
    public $lainhargaprimerorder;
    public $lainhargasekunderorder;
    public $lainhargalabelorder;
    public $lainhargatotalorder;
    public $isibahanaktif;
    public $isibahanlain;
    public $isiparfum;
    public $isiestetika;
    public $kemasanwadah;
    public $kemasantutup;
    public $kemasansekunder;
    public $desainlabel;
    public $cetaklabel;
    public $lainlain;
    public $deliverypickup;
    public $deliverysinglepoint;
    public $deliverymultipoint;
    public $deliveryjumlahpoint;
    public $deliverytermslain;
    public $catatankhusus;
    public $dibuatdi;
    public $tanggal;
    public $created_by;

    // Page ID
    public $PageID = ""; // To be overridden by subclass

    // Constructor
    public function __construct()
    {
        global $Language, $CurrentLanguage;
        parent::__construct();

        // Language object
        $Language = Container("language");
        $this->TableVar = 'npd_terms';
        $this->TableName = 'npd_terms';
        $this->TableType = 'TABLE';

        // Update Table
        $this->UpdateTable = "`npd_terms`";
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
        $this->id = new DbField('npd_terms', 'npd_terms', 'x_id', 'id', '`id`', '`id`', 3, 11, -1, false, '`id`', false, false, false, 'FORMATTED TEXT', 'NO');
        $this->id->IsAutoIncrement = true; // Autoincrement field
        $this->id->IsPrimaryKey = true; // Primary key field
        $this->id->Sortable = true; // Allow sort
        $this->id->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->id->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->id->Param, "CustomMsg");
        $this->Fields['id'] = &$this->id;

        // idnpd
        $this->idnpd = new DbField('npd_terms', 'npd_terms', 'x_idnpd', 'idnpd', '`idnpd`', '`idnpd`', 3, 11, -1, false, '`idnpd`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->idnpd->Nullable = false; // NOT NULL field
        $this->idnpd->Sortable = true; // Allow sort
        $this->idnpd->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->idnpd->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->idnpd->Param, "CustomMsg");
        $this->Fields['idnpd'] = &$this->idnpd;

        // status
        $this->status = new DbField('npd_terms', 'npd_terms', 'x_status', 'status', '`status`', '`status`', 200, 50, -1, false, '`status`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->status->Sortable = true; // Allow sort
        $this->status->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->status->Param, "CustomMsg");
        $this->Fields['status'] = &$this->status;

        // tglsubmit
        $this->tglsubmit = new DbField('npd_terms', 'npd_terms', 'x_tglsubmit', 'tglsubmit', '`tglsubmit`', CastDateFieldForLike("`tglsubmit`", 0, "DB"), 135, 19, 0, false, '`tglsubmit`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tglsubmit->Sortable = true; // Allow sort
        $this->tglsubmit->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tglsubmit->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tglsubmit->Param, "CustomMsg");
        $this->Fields['tglsubmit'] = &$this->tglsubmit;

        // sifatorder
        $this->sifatorder = new DbField('npd_terms', 'npd_terms', 'x_sifatorder', 'sifatorder', '`sifatorder`', '`sifatorder`', 16, 1, -1, false, '`sifatorder`', false, false, false, 'FORMATTED TEXT', 'CHECKBOX');
        $this->sifatorder->Nullable = false; // NOT NULL field
        $this->sifatorder->Sortable = true; // Allow sort
        $this->sifatorder->DataType = DATATYPE_BOOLEAN;
        switch ($CurrentLanguage) {
            case "en":
                $this->sifatorder->Lookup = new Lookup('sifatorder', 'npd_terms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
            default:
                $this->sifatorder->Lookup = new Lookup('sifatorder', 'npd_terms', false, '', ["","","",""], [], [], [], [], [], [], '', '');
                break;
        }
        $this->sifatorder->OptionCount = 2;
        $this->sifatorder->DefaultErrorMessage = $Language->phrase("IncorrectField");
        $this->sifatorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->sifatorder->Param, "CustomMsg");
        $this->Fields['sifatorder'] = &$this->sifatorder;

        // ukuranutama
        $this->ukuranutama = new DbField('npd_terms', 'npd_terms', 'x_ukuranutama', 'ukuranutama', '`ukuranutama`', '`ukuranutama`', 200, 50, -1, false, '`ukuranutama`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuranutama->Sortable = true; // Allow sort
        $this->ukuranutama->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuranutama->Param, "CustomMsg");
        $this->Fields['ukuranutama'] = &$this->ukuranutama;

        // utamahargaisipcs
        $this->utamahargaisipcs = new DbField('npd_terms', 'npd_terms', 'x_utamahargaisipcs', 'utamahargaisipcs', '`utamahargaisipcs`', '`utamahargaisipcs`', 20, 20, -1, false, '`utamahargaisipcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargaisipcs->Sortable = true; // Allow sort
        $this->utamahargaisipcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargaisipcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargaisipcs->Param, "CustomMsg");
        $this->Fields['utamahargaisipcs'] = &$this->utamahargaisipcs;

        // utamahargaprimerpcs
        $this->utamahargaprimerpcs = new DbField('npd_terms', 'npd_terms', 'x_utamahargaprimerpcs', 'utamahargaprimerpcs', '`utamahargaprimerpcs`', '`utamahargaprimerpcs`', 20, 20, -1, false, '`utamahargaprimerpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargaprimerpcs->Sortable = true; // Allow sort
        $this->utamahargaprimerpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargaprimerpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargaprimerpcs->Param, "CustomMsg");
        $this->Fields['utamahargaprimerpcs'] = &$this->utamahargaprimerpcs;

        // utamahargasekunderpcs
        $this->utamahargasekunderpcs = new DbField('npd_terms', 'npd_terms', 'x_utamahargasekunderpcs', 'utamahargasekunderpcs', '`utamahargasekunderpcs`', '`utamahargasekunderpcs`', 20, 20, -1, false, '`utamahargasekunderpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargasekunderpcs->Sortable = true; // Allow sort
        $this->utamahargasekunderpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargasekunderpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargasekunderpcs->Param, "CustomMsg");
        $this->Fields['utamahargasekunderpcs'] = &$this->utamahargasekunderpcs;

        // utamahargalabelpcs
        $this->utamahargalabelpcs = new DbField('npd_terms', 'npd_terms', 'x_utamahargalabelpcs', 'utamahargalabelpcs', '`utamahargalabelpcs`', '`utamahargalabelpcs`', 20, 20, -1, false, '`utamahargalabelpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargalabelpcs->Sortable = true; // Allow sort
        $this->utamahargalabelpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargalabelpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargalabelpcs->Param, "CustomMsg");
        $this->Fields['utamahargalabelpcs'] = &$this->utamahargalabelpcs;

        // utamahargatotalpcs
        $this->utamahargatotalpcs = new DbField('npd_terms', 'npd_terms', 'x_utamahargatotalpcs', 'utamahargatotalpcs', '`utamahargatotalpcs`', '`utamahargatotalpcs`', 20, 20, -1, false, '`utamahargatotalpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargatotalpcs->Sortable = true; // Allow sort
        $this->utamahargatotalpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargatotalpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargatotalpcs->Param, "CustomMsg");
        $this->Fields['utamahargatotalpcs'] = &$this->utamahargatotalpcs;

        // utamahargaisiorder
        $this->utamahargaisiorder = new DbField('npd_terms', 'npd_terms', 'x_utamahargaisiorder', 'utamahargaisiorder', '`utamahargaisiorder`', '`utamahargaisiorder`', 20, 20, -1, false, '`utamahargaisiorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargaisiorder->Sortable = true; // Allow sort
        $this->utamahargaisiorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargaisiorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargaisiorder->Param, "CustomMsg");
        $this->Fields['utamahargaisiorder'] = &$this->utamahargaisiorder;

        // utamahargaprimerorder
        $this->utamahargaprimerorder = new DbField('npd_terms', 'npd_terms', 'x_utamahargaprimerorder', 'utamahargaprimerorder', '`utamahargaprimerorder`', '`utamahargaprimerorder`', 20, 20, -1, false, '`utamahargaprimerorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargaprimerorder->Sortable = true; // Allow sort
        $this->utamahargaprimerorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargaprimerorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargaprimerorder->Param, "CustomMsg");
        $this->Fields['utamahargaprimerorder'] = &$this->utamahargaprimerorder;

        // utamahargasekunderorder
        $this->utamahargasekunderorder = new DbField('npd_terms', 'npd_terms', 'x_utamahargasekunderorder', 'utamahargasekunderorder', '`utamahargasekunderorder`', '`utamahargasekunderorder`', 20, 20, -1, false, '`utamahargasekunderorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargasekunderorder->Sortable = true; // Allow sort
        $this->utamahargasekunderorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargasekunderorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargasekunderorder->Param, "CustomMsg");
        $this->Fields['utamahargasekunderorder'] = &$this->utamahargasekunderorder;

        // utamahargalabelorder
        $this->utamahargalabelorder = new DbField('npd_terms', 'npd_terms', 'x_utamahargalabelorder', 'utamahargalabelorder', '`utamahargalabelorder`', '`utamahargalabelorder`', 20, 20, -1, false, '`utamahargalabelorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargalabelorder->Sortable = true; // Allow sort
        $this->utamahargalabelorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargalabelorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargalabelorder->Param, "CustomMsg");
        $this->Fields['utamahargalabelorder'] = &$this->utamahargalabelorder;

        // utamahargatotalorder
        $this->utamahargatotalorder = new DbField('npd_terms', 'npd_terms', 'x_utamahargatotalorder', 'utamahargatotalorder', '`utamahargatotalorder`', '`utamahargatotalorder`', 20, 20, -1, false, '`utamahargatotalorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->utamahargatotalorder->Sortable = true; // Allow sort
        $this->utamahargatotalorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->utamahargatotalorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->utamahargatotalorder->Param, "CustomMsg");
        $this->Fields['utamahargatotalorder'] = &$this->utamahargatotalorder;

        // ukuranlain
        $this->ukuranlain = new DbField('npd_terms', 'npd_terms', 'x_ukuranlain', 'ukuranlain', '`ukuranlain`', '`ukuranlain`', 200, 50, -1, false, '`ukuranlain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->ukuranlain->Sortable = true; // Allow sort
        $this->ukuranlain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->ukuranlain->Param, "CustomMsg");
        $this->Fields['ukuranlain'] = &$this->ukuranlain;

        // lainhargaisipcs
        $this->lainhargaisipcs = new DbField('npd_terms', 'npd_terms', 'x_lainhargaisipcs', 'lainhargaisipcs', '`lainhargaisipcs`', '`lainhargaisipcs`', 20, 20, -1, false, '`lainhargaisipcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargaisipcs->Sortable = true; // Allow sort
        $this->lainhargaisipcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargaisipcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargaisipcs->Param, "CustomMsg");
        $this->Fields['lainhargaisipcs'] = &$this->lainhargaisipcs;

        // lainhargaprimerpcs
        $this->lainhargaprimerpcs = new DbField('npd_terms', 'npd_terms', 'x_lainhargaprimerpcs', 'lainhargaprimerpcs', '`lainhargaprimerpcs`', '`lainhargaprimerpcs`', 20, 20, -1, false, '`lainhargaprimerpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargaprimerpcs->Sortable = true; // Allow sort
        $this->lainhargaprimerpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargaprimerpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargaprimerpcs->Param, "CustomMsg");
        $this->Fields['lainhargaprimerpcs'] = &$this->lainhargaprimerpcs;

        // lainhargasekunderpcs
        $this->lainhargasekunderpcs = new DbField('npd_terms', 'npd_terms', 'x_lainhargasekunderpcs', 'lainhargasekunderpcs', '`lainhargasekunderpcs`', '`lainhargasekunderpcs`', 20, 20, -1, false, '`lainhargasekunderpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargasekunderpcs->Sortable = true; // Allow sort
        $this->lainhargasekunderpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargasekunderpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargasekunderpcs->Param, "CustomMsg");
        $this->Fields['lainhargasekunderpcs'] = &$this->lainhargasekunderpcs;

        // lainhargalabelpcs
        $this->lainhargalabelpcs = new DbField('npd_terms', 'npd_terms', 'x_lainhargalabelpcs', 'lainhargalabelpcs', '`lainhargalabelpcs`', '`lainhargalabelpcs`', 20, 20, -1, false, '`lainhargalabelpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargalabelpcs->Sortable = true; // Allow sort
        $this->lainhargalabelpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargalabelpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargalabelpcs->Param, "CustomMsg");
        $this->Fields['lainhargalabelpcs'] = &$this->lainhargalabelpcs;

        // lainhargatotalpcs
        $this->lainhargatotalpcs = new DbField('npd_terms', 'npd_terms', 'x_lainhargatotalpcs', 'lainhargatotalpcs', '`lainhargatotalpcs`', '`lainhargatotalpcs`', 20, 20, -1, false, '`lainhargatotalpcs`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargatotalpcs->Sortable = true; // Allow sort
        $this->lainhargatotalpcs->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargatotalpcs->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargatotalpcs->Param, "CustomMsg");
        $this->Fields['lainhargatotalpcs'] = &$this->lainhargatotalpcs;

        // lainhargaisiorder
        $this->lainhargaisiorder = new DbField('npd_terms', 'npd_terms', 'x_lainhargaisiorder', 'lainhargaisiorder', '`lainhargaisiorder`', '`lainhargaisiorder`', 20, 20, -1, false, '`lainhargaisiorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargaisiorder->Sortable = true; // Allow sort
        $this->lainhargaisiorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargaisiorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargaisiorder->Param, "CustomMsg");
        $this->Fields['lainhargaisiorder'] = &$this->lainhargaisiorder;

        // lainhargaprimerorder
        $this->lainhargaprimerorder = new DbField('npd_terms', 'npd_terms', 'x_lainhargaprimerorder', 'lainhargaprimerorder', '`lainhargaprimerorder`', '`lainhargaprimerorder`', 20, 20, -1, false, '`lainhargaprimerorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargaprimerorder->Sortable = true; // Allow sort
        $this->lainhargaprimerorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargaprimerorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargaprimerorder->Param, "CustomMsg");
        $this->Fields['lainhargaprimerorder'] = &$this->lainhargaprimerorder;

        // lainhargasekunderorder
        $this->lainhargasekunderorder = new DbField('npd_terms', 'npd_terms', 'x_lainhargasekunderorder', 'lainhargasekunderorder', '`lainhargasekunderorder`', '`lainhargasekunderorder`', 20, 20, -1, false, '`lainhargasekunderorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargasekunderorder->Sortable = true; // Allow sort
        $this->lainhargasekunderorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargasekunderorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargasekunderorder->Param, "CustomMsg");
        $this->Fields['lainhargasekunderorder'] = &$this->lainhargasekunderorder;

        // lainhargalabelorder
        $this->lainhargalabelorder = new DbField('npd_terms', 'npd_terms', 'x_lainhargalabelorder', 'lainhargalabelorder', '`lainhargalabelorder`', '`lainhargalabelorder`', 20, 20, -1, false, '`lainhargalabelorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargalabelorder->Sortable = true; // Allow sort
        $this->lainhargalabelorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargalabelorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargalabelorder->Param, "CustomMsg");
        $this->Fields['lainhargalabelorder'] = &$this->lainhargalabelorder;

        // lainhargatotalorder
        $this->lainhargatotalorder = new DbField('npd_terms', 'npd_terms', 'x_lainhargatotalorder', 'lainhargatotalorder', '`lainhargatotalorder`', '`lainhargatotalorder`', 20, 20, -1, false, '`lainhargatotalorder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainhargatotalorder->Sortable = true; // Allow sort
        $this->lainhargatotalorder->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->lainhargatotalorder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainhargatotalorder->Param, "CustomMsg");
        $this->Fields['lainhargatotalorder'] = &$this->lainhargatotalorder;

        // isibahanaktif
        $this->isibahanaktif = new DbField('npd_terms', 'npd_terms', 'x_isibahanaktif', 'isibahanaktif', '`isibahanaktif`', '`isibahanaktif`', 200, 50, -1, false, '`isibahanaktif`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isibahanaktif->Sortable = true; // Allow sort
        $this->isibahanaktif->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isibahanaktif->Param, "CustomMsg");
        $this->Fields['isibahanaktif'] = &$this->isibahanaktif;

        // isibahanlain
        $this->isibahanlain = new DbField('npd_terms', 'npd_terms', 'x_isibahanlain', 'isibahanlain', '`isibahanlain`', '`isibahanlain`', 200, 50, -1, false, '`isibahanlain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isibahanlain->Sortable = true; // Allow sort
        $this->isibahanlain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isibahanlain->Param, "CustomMsg");
        $this->Fields['isibahanlain'] = &$this->isibahanlain;

        // isiparfum
        $this->isiparfum = new DbField('npd_terms', 'npd_terms', 'x_isiparfum', 'isiparfum', '`isiparfum`', '`isiparfum`', 200, 50, -1, false, '`isiparfum`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isiparfum->Sortable = true; // Allow sort
        $this->isiparfum->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isiparfum->Param, "CustomMsg");
        $this->Fields['isiparfum'] = &$this->isiparfum;

        // isiestetika
        $this->isiestetika = new DbField('npd_terms', 'npd_terms', 'x_isiestetika', 'isiestetika', '`isiestetika`', '`isiestetika`', 200, 50, -1, false, '`isiestetika`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->isiestetika->Sortable = true; // Allow sort
        $this->isiestetika->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->isiestetika->Param, "CustomMsg");
        $this->Fields['isiestetika'] = &$this->isiestetika;

        // kemasanwadah
        $this->kemasanwadah = new DbField('npd_terms', 'npd_terms', 'x_kemasanwadah', 'kemasanwadah', '`kemasanwadah`', '`kemasanwadah`', 3, 11, -1, false, '`kemasanwadah`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasanwadah->Sortable = true; // Allow sort
        $this->kemasanwadah->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->kemasanwadah->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasanwadah->Param, "CustomMsg");
        $this->Fields['kemasanwadah'] = &$this->kemasanwadah;

        // kemasantutup
        $this->kemasantutup = new DbField('npd_terms', 'npd_terms', 'x_kemasantutup', 'kemasantutup', '`kemasantutup`', '`kemasantutup`', 3, 11, -1, false, '`kemasantutup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasantutup->Sortable = true; // Allow sort
        $this->kemasantutup->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->kemasantutup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasantutup->Param, "CustomMsg");
        $this->Fields['kemasantutup'] = &$this->kemasantutup;

        // kemasansekunder
        $this->kemasansekunder = new DbField('npd_terms', 'npd_terms', 'x_kemasansekunder', 'kemasansekunder', '`kemasansekunder`', '`kemasansekunder`', 200, 50, -1, false, '`kemasansekunder`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->kemasansekunder->Sortable = true; // Allow sort
        $this->kemasansekunder->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->kemasansekunder->Param, "CustomMsg");
        $this->Fields['kemasansekunder'] = &$this->kemasansekunder;

        // desainlabel
        $this->desainlabel = new DbField('npd_terms', 'npd_terms', 'x_desainlabel', 'desainlabel', '`desainlabel`', '`desainlabel`', 200, 255, -1, false, '`desainlabel`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->desainlabel->Sortable = true; // Allow sort
        $this->desainlabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->desainlabel->Param, "CustomMsg");
        $this->Fields['desainlabel'] = &$this->desainlabel;

        // cetaklabel
        $this->cetaklabel = new DbField('npd_terms', 'npd_terms', 'x_cetaklabel', 'cetaklabel', '`cetaklabel`', '`cetaklabel`', 200, 50, -1, false, '`cetaklabel`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->cetaklabel->Sortable = true; // Allow sort
        $this->cetaklabel->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->cetaklabel->Param, "CustomMsg");
        $this->Fields['cetaklabel'] = &$this->cetaklabel;

        // lainlain
        $this->lainlain = new DbField('npd_terms', 'npd_terms', 'x_lainlain', 'lainlain', '`lainlain`', '`lainlain`', 200, 50, -1, false, '`lainlain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->lainlain->Sortable = true; // Allow sort
        $this->lainlain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->lainlain->Param, "CustomMsg");
        $this->Fields['lainlain'] = &$this->lainlain;

        // deliverypickup
        $this->deliverypickup = new DbField('npd_terms', 'npd_terms', 'x_deliverypickup', 'deliverypickup', '`deliverypickup`', '`deliverypickup`', 200, 50, -1, false, '`deliverypickup`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->deliverypickup->Sortable = true; // Allow sort
        $this->deliverypickup->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->deliverypickup->Param, "CustomMsg");
        $this->Fields['deliverypickup'] = &$this->deliverypickup;

        // deliverysinglepoint
        $this->deliverysinglepoint = new DbField('npd_terms', 'npd_terms', 'x_deliverysinglepoint', 'deliverysinglepoint', '`deliverysinglepoint`', '`deliverysinglepoint`', 200, 50, -1, false, '`deliverysinglepoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->deliverysinglepoint->Sortable = true; // Allow sort
        $this->deliverysinglepoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->deliverysinglepoint->Param, "CustomMsg");
        $this->Fields['deliverysinglepoint'] = &$this->deliverysinglepoint;

        // deliverymultipoint
        $this->deliverymultipoint = new DbField('npd_terms', 'npd_terms', 'x_deliverymultipoint', 'deliverymultipoint', '`deliverymultipoint`', '`deliverymultipoint`', 200, 50, -1, false, '`deliverymultipoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->deliverymultipoint->Sortable = true; // Allow sort
        $this->deliverymultipoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->deliverymultipoint->Param, "CustomMsg");
        $this->Fields['deliverymultipoint'] = &$this->deliverymultipoint;

        // deliveryjumlahpoint
        $this->deliveryjumlahpoint = new DbField('npd_terms', 'npd_terms', 'x_deliveryjumlahpoint', 'deliveryjumlahpoint', '`deliveryjumlahpoint`', '`deliveryjumlahpoint`', 200, 50, -1, false, '`deliveryjumlahpoint`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->deliveryjumlahpoint->Sortable = true; // Allow sort
        $this->deliveryjumlahpoint->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->deliveryjumlahpoint->Param, "CustomMsg");
        $this->Fields['deliveryjumlahpoint'] = &$this->deliveryjumlahpoint;

        // deliverytermslain
        $this->deliverytermslain = new DbField('npd_terms', 'npd_terms', 'x_deliverytermslain', 'deliverytermslain', '`deliverytermslain`', '`deliverytermslain`', 200, 50, -1, false, '`deliverytermslain`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->deliverytermslain->Sortable = true; // Allow sort
        $this->deliverytermslain->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->deliverytermslain->Param, "CustomMsg");
        $this->Fields['deliverytermslain'] = &$this->deliverytermslain;

        // catatankhusus
        $this->catatankhusus = new DbField('npd_terms', 'npd_terms', 'x_catatankhusus', 'catatankhusus', '`catatankhusus`', '`catatankhusus`', 200, 50, -1, false, '`catatankhusus`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->catatankhusus->Sortable = true; // Allow sort
        $this->catatankhusus->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->catatankhusus->Param, "CustomMsg");
        $this->Fields['catatankhusus'] = &$this->catatankhusus;

        // dibuatdi
        $this->dibuatdi = new DbField('npd_terms', 'npd_terms', 'x_dibuatdi', 'dibuatdi', '`dibuatdi`', '`dibuatdi`', 200, 50, -1, false, '`dibuatdi`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->dibuatdi->Sortable = true; // Allow sort
        $this->dibuatdi->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->dibuatdi->Param, "CustomMsg");
        $this->Fields['dibuatdi'] = &$this->dibuatdi;

        // tanggal
        $this->tanggal = new DbField('npd_terms', 'npd_terms', 'x_tanggal', 'tanggal', '`tanggal`', CastDateFieldForLike("`tanggal`", 0, "DB"), 135, 19, 0, false, '`tanggal`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->tanggal->Nullable = false; // NOT NULL field
        $this->tanggal->Required = true; // Required field
        $this->tanggal->Sortable = true; // Allow sort
        $this->tanggal->DefaultErrorMessage = str_replace("%s", $GLOBALS["DATE_FORMAT"], $Language->phrase("IncorrectDate"));
        $this->tanggal->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->tanggal->Param, "CustomMsg");
        $this->Fields['tanggal'] = &$this->tanggal;

        // created_by
        $this->created_by = new DbField('npd_terms', 'npd_terms', 'x_created_by', 'created_by', '`created_by`', '`created_by`', 3, 11, -1, false, '`created_by`', false, false, false, 'FORMATTED TEXT', 'TEXT');
        $this->created_by->Sortable = true; // Allow sort
        $this->created_by->DefaultErrorMessage = $Language->phrase("IncorrectInteger");
        $this->created_by->CustomMsg = $Language->FieldPhrase($this->TableVar, $this->created_by->Param, "CustomMsg");
        $this->Fields['created_by'] = &$this->created_by;
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
        return ($this->SqlFrom != "") ? $this->SqlFrom : "`npd_terms`";
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
        $this->idnpd->DbValue = $row['idnpd'];
        $this->status->DbValue = $row['status'];
        $this->tglsubmit->DbValue = $row['tglsubmit'];
        $this->sifatorder->DbValue = $row['sifatorder'];
        $this->ukuranutama->DbValue = $row['ukuranutama'];
        $this->utamahargaisipcs->DbValue = $row['utamahargaisipcs'];
        $this->utamahargaprimerpcs->DbValue = $row['utamahargaprimerpcs'];
        $this->utamahargasekunderpcs->DbValue = $row['utamahargasekunderpcs'];
        $this->utamahargalabelpcs->DbValue = $row['utamahargalabelpcs'];
        $this->utamahargatotalpcs->DbValue = $row['utamahargatotalpcs'];
        $this->utamahargaisiorder->DbValue = $row['utamahargaisiorder'];
        $this->utamahargaprimerorder->DbValue = $row['utamahargaprimerorder'];
        $this->utamahargasekunderorder->DbValue = $row['utamahargasekunderorder'];
        $this->utamahargalabelorder->DbValue = $row['utamahargalabelorder'];
        $this->utamahargatotalorder->DbValue = $row['utamahargatotalorder'];
        $this->ukuranlain->DbValue = $row['ukuranlain'];
        $this->lainhargaisipcs->DbValue = $row['lainhargaisipcs'];
        $this->lainhargaprimerpcs->DbValue = $row['lainhargaprimerpcs'];
        $this->lainhargasekunderpcs->DbValue = $row['lainhargasekunderpcs'];
        $this->lainhargalabelpcs->DbValue = $row['lainhargalabelpcs'];
        $this->lainhargatotalpcs->DbValue = $row['lainhargatotalpcs'];
        $this->lainhargaisiorder->DbValue = $row['lainhargaisiorder'];
        $this->lainhargaprimerorder->DbValue = $row['lainhargaprimerorder'];
        $this->lainhargasekunderorder->DbValue = $row['lainhargasekunderorder'];
        $this->lainhargalabelorder->DbValue = $row['lainhargalabelorder'];
        $this->lainhargatotalorder->DbValue = $row['lainhargatotalorder'];
        $this->isibahanaktif->DbValue = $row['isibahanaktif'];
        $this->isibahanlain->DbValue = $row['isibahanlain'];
        $this->isiparfum->DbValue = $row['isiparfum'];
        $this->isiestetika->DbValue = $row['isiestetika'];
        $this->kemasanwadah->DbValue = $row['kemasanwadah'];
        $this->kemasantutup->DbValue = $row['kemasantutup'];
        $this->kemasansekunder->DbValue = $row['kemasansekunder'];
        $this->desainlabel->DbValue = $row['desainlabel'];
        $this->cetaklabel->DbValue = $row['cetaklabel'];
        $this->lainlain->DbValue = $row['lainlain'];
        $this->deliverypickup->DbValue = $row['deliverypickup'];
        $this->deliverysinglepoint->DbValue = $row['deliverysinglepoint'];
        $this->deliverymultipoint->DbValue = $row['deliverymultipoint'];
        $this->deliveryjumlahpoint->DbValue = $row['deliveryjumlahpoint'];
        $this->deliverytermslain->DbValue = $row['deliverytermslain'];
        $this->catatankhusus->DbValue = $row['catatankhusus'];
        $this->dibuatdi->DbValue = $row['dibuatdi'];
        $this->tanggal->DbValue = $row['tanggal'];
        $this->created_by->DbValue = $row['created_by'];
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
        return $_SESSION[$name] ?? GetUrl("NpdTermsList");
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
        if ($pageName == "NpdTermsView") {
            return $Language->phrase("View");
        } elseif ($pageName == "NpdTermsEdit") {
            return $Language->phrase("Edit");
        } elseif ($pageName == "NpdTermsAdd") {
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
                return "NpdTermsView";
            case Config("API_ADD_ACTION"):
                return "NpdTermsAdd";
            case Config("API_EDIT_ACTION"):
                return "NpdTermsEdit";
            case Config("API_DELETE_ACTION"):
                return "NpdTermsDelete";
            case Config("API_LIST_ACTION"):
                return "NpdTermsList";
            default:
                return "";
        }
    }

    // List URL
    public function getListUrl()
    {
        return "NpdTermsList";
    }

    // View URL
    public function getViewUrl($parm = "")
    {
        if ($parm != "") {
            $url = $this->keyUrl("NpdTermsView", $this->getUrlParm($parm));
        } else {
            $url = $this->keyUrl("NpdTermsView", $this->getUrlParm(Config("TABLE_SHOW_DETAIL") . "="));
        }
        return $this->addMasterUrl($url);
    }

    // Add URL
    public function getAddUrl($parm = "")
    {
        if ($parm != "") {
            $url = "NpdTermsAdd?" . $this->getUrlParm($parm);
        } else {
            $url = "NpdTermsAdd";
        }
        return $this->addMasterUrl($url);
    }

    // Edit URL
    public function getEditUrl($parm = "")
    {
        $url = $this->keyUrl("NpdTermsEdit", $this->getUrlParm($parm));
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
        $url = $this->keyUrl("NpdTermsAdd", $this->getUrlParm($parm));
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
        return $this->keyUrl("NpdTermsDelete", $this->getUrlParm());
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
        $this->idnpd->setDbValue($row['idnpd']);
        $this->status->setDbValue($row['status']);
        $this->tglsubmit->setDbValue($row['tglsubmit']);
        $this->sifatorder->setDbValue($row['sifatorder']);
        $this->ukuranutama->setDbValue($row['ukuranutama']);
        $this->utamahargaisipcs->setDbValue($row['utamahargaisipcs']);
        $this->utamahargaprimerpcs->setDbValue($row['utamahargaprimerpcs']);
        $this->utamahargasekunderpcs->setDbValue($row['utamahargasekunderpcs']);
        $this->utamahargalabelpcs->setDbValue($row['utamahargalabelpcs']);
        $this->utamahargatotalpcs->setDbValue($row['utamahargatotalpcs']);
        $this->utamahargaisiorder->setDbValue($row['utamahargaisiorder']);
        $this->utamahargaprimerorder->setDbValue($row['utamahargaprimerorder']);
        $this->utamahargasekunderorder->setDbValue($row['utamahargasekunderorder']);
        $this->utamahargalabelorder->setDbValue($row['utamahargalabelorder']);
        $this->utamahargatotalorder->setDbValue($row['utamahargatotalorder']);
        $this->ukuranlain->setDbValue($row['ukuranlain']);
        $this->lainhargaisipcs->setDbValue($row['lainhargaisipcs']);
        $this->lainhargaprimerpcs->setDbValue($row['lainhargaprimerpcs']);
        $this->lainhargasekunderpcs->setDbValue($row['lainhargasekunderpcs']);
        $this->lainhargalabelpcs->setDbValue($row['lainhargalabelpcs']);
        $this->lainhargatotalpcs->setDbValue($row['lainhargatotalpcs']);
        $this->lainhargaisiorder->setDbValue($row['lainhargaisiorder']);
        $this->lainhargaprimerorder->setDbValue($row['lainhargaprimerorder']);
        $this->lainhargasekunderorder->setDbValue($row['lainhargasekunderorder']);
        $this->lainhargalabelorder->setDbValue($row['lainhargalabelorder']);
        $this->lainhargatotalorder->setDbValue($row['lainhargatotalorder']);
        $this->isibahanaktif->setDbValue($row['isibahanaktif']);
        $this->isibahanlain->setDbValue($row['isibahanlain']);
        $this->isiparfum->setDbValue($row['isiparfum']);
        $this->isiestetika->setDbValue($row['isiestetika']);
        $this->kemasanwadah->setDbValue($row['kemasanwadah']);
        $this->kemasantutup->setDbValue($row['kemasantutup']);
        $this->kemasansekunder->setDbValue($row['kemasansekunder']);
        $this->desainlabel->setDbValue($row['desainlabel']);
        $this->cetaklabel->setDbValue($row['cetaklabel']);
        $this->lainlain->setDbValue($row['lainlain']);
        $this->deliverypickup->setDbValue($row['deliverypickup']);
        $this->deliverysinglepoint->setDbValue($row['deliverysinglepoint']);
        $this->deliverymultipoint->setDbValue($row['deliverymultipoint']);
        $this->deliveryjumlahpoint->setDbValue($row['deliveryjumlahpoint']);
        $this->deliverytermslain->setDbValue($row['deliverytermslain']);
        $this->catatankhusus->setDbValue($row['catatankhusus']);
        $this->dibuatdi->setDbValue($row['dibuatdi']);
        $this->tanggal->setDbValue($row['tanggal']);
        $this->created_by->setDbValue($row['created_by']);
    }

    // Render list row values
    public function renderListRow()
    {
        global $Security, $CurrentLanguage, $Language;

        // Call Row Rendering event
        $this->rowRendering();

        // Common render codes

        // id

        // idnpd

        // status

        // tglsubmit

        // sifatorder

        // ukuranutama

        // utamahargaisipcs

        // utamahargaprimerpcs

        // utamahargasekunderpcs

        // utamahargalabelpcs

        // utamahargatotalpcs

        // utamahargaisiorder

        // utamahargaprimerorder

        // utamahargasekunderorder

        // utamahargalabelorder

        // utamahargatotalorder

        // ukuranlain

        // lainhargaisipcs

        // lainhargaprimerpcs

        // lainhargasekunderpcs

        // lainhargalabelpcs

        // lainhargatotalpcs

        // lainhargaisiorder

        // lainhargaprimerorder

        // lainhargasekunderorder

        // lainhargalabelorder

        // lainhargatotalorder

        // isibahanaktif

        // isibahanlain

        // isiparfum

        // isiestetika

        // kemasanwadah

        // kemasantutup

        // kemasansekunder

        // desainlabel

        // cetaklabel

        // lainlain

        // deliverypickup

        // deliverysinglepoint

        // deliverymultipoint

        // deliveryjumlahpoint

        // deliverytermslain

        // catatankhusus

        // dibuatdi

        // tanggal

        // created_by

        // id
        $this->id->ViewValue = $this->id->CurrentValue;
        $this->id->ViewCustomAttributes = "";

        // idnpd
        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
        $this->idnpd->ViewValue = FormatNumber($this->idnpd->ViewValue, 0, -2, -2, -2);
        $this->idnpd->ViewCustomAttributes = "";

        // status
        $this->status->ViewValue = $this->status->CurrentValue;
        $this->status->ViewCustomAttributes = "";

        // tglsubmit
        $this->tglsubmit->ViewValue = $this->tglsubmit->CurrentValue;
        $this->tglsubmit->ViewValue = FormatDateTime($this->tglsubmit->ViewValue, 0);
        $this->tglsubmit->ViewCustomAttributes = "";

        // sifatorder
        if (ConvertToBool($this->sifatorder->CurrentValue)) {
            $this->sifatorder->ViewValue = $this->sifatorder->tagCaption(1) != "" ? $this->sifatorder->tagCaption(1) : "Yes";
        } else {
            $this->sifatorder->ViewValue = $this->sifatorder->tagCaption(2) != "" ? $this->sifatorder->tagCaption(2) : "No";
        }
        $this->sifatorder->ViewCustomAttributes = "";

        // ukuranutama
        $this->ukuranutama->ViewValue = $this->ukuranutama->CurrentValue;
        $this->ukuranutama->ViewCustomAttributes = "";

        // utamahargaisipcs
        $this->utamahargaisipcs->ViewValue = $this->utamahargaisipcs->CurrentValue;
        $this->utamahargaisipcs->ViewValue = FormatNumber($this->utamahargaisipcs->ViewValue, 0, -2, -2, -2);
        $this->utamahargaisipcs->ViewCustomAttributes = "";

        // utamahargaprimerpcs
        $this->utamahargaprimerpcs->ViewValue = $this->utamahargaprimerpcs->CurrentValue;
        $this->utamahargaprimerpcs->ViewValue = FormatNumber($this->utamahargaprimerpcs->ViewValue, 0, -2, -2, -2);
        $this->utamahargaprimerpcs->ViewCustomAttributes = "";

        // utamahargasekunderpcs
        $this->utamahargasekunderpcs->ViewValue = $this->utamahargasekunderpcs->CurrentValue;
        $this->utamahargasekunderpcs->ViewValue = FormatNumber($this->utamahargasekunderpcs->ViewValue, 0, -2, -2, -2);
        $this->utamahargasekunderpcs->ViewCustomAttributes = "";

        // utamahargalabelpcs
        $this->utamahargalabelpcs->ViewValue = $this->utamahargalabelpcs->CurrentValue;
        $this->utamahargalabelpcs->ViewValue = FormatNumber($this->utamahargalabelpcs->ViewValue, 0, -2, -2, -2);
        $this->utamahargalabelpcs->ViewCustomAttributes = "";

        // utamahargatotalpcs
        $this->utamahargatotalpcs->ViewValue = $this->utamahargatotalpcs->CurrentValue;
        $this->utamahargatotalpcs->ViewValue = FormatNumber($this->utamahargatotalpcs->ViewValue, 0, -2, -2, -2);
        $this->utamahargatotalpcs->ViewCustomAttributes = "";

        // utamahargaisiorder
        $this->utamahargaisiorder->ViewValue = $this->utamahargaisiorder->CurrentValue;
        $this->utamahargaisiorder->ViewValue = FormatNumber($this->utamahargaisiorder->ViewValue, 0, -2, -2, -2);
        $this->utamahargaisiorder->ViewCustomAttributes = "";

        // utamahargaprimerorder
        $this->utamahargaprimerorder->ViewValue = $this->utamahargaprimerorder->CurrentValue;
        $this->utamahargaprimerorder->ViewValue = FormatNumber($this->utamahargaprimerorder->ViewValue, 0, -2, -2, -2);
        $this->utamahargaprimerorder->ViewCustomAttributes = "";

        // utamahargasekunderorder
        $this->utamahargasekunderorder->ViewValue = $this->utamahargasekunderorder->CurrentValue;
        $this->utamahargasekunderorder->ViewValue = FormatNumber($this->utamahargasekunderorder->ViewValue, 0, -2, -2, -2);
        $this->utamahargasekunderorder->ViewCustomAttributes = "";

        // utamahargalabelorder
        $this->utamahargalabelorder->ViewValue = $this->utamahargalabelorder->CurrentValue;
        $this->utamahargalabelorder->ViewValue = FormatNumber($this->utamahargalabelorder->ViewValue, 0, -2, -2, -2);
        $this->utamahargalabelorder->ViewCustomAttributes = "";

        // utamahargatotalorder
        $this->utamahargatotalorder->ViewValue = $this->utamahargatotalorder->CurrentValue;
        $this->utamahargatotalorder->ViewValue = FormatNumber($this->utamahargatotalorder->ViewValue, 0, -2, -2, -2);
        $this->utamahargatotalorder->ViewCustomAttributes = "";

        // ukuranlain
        $this->ukuranlain->ViewValue = $this->ukuranlain->CurrentValue;
        $this->ukuranlain->ViewCustomAttributes = "";

        // lainhargaisipcs
        $this->lainhargaisipcs->ViewValue = $this->lainhargaisipcs->CurrentValue;
        $this->lainhargaisipcs->ViewValue = FormatNumber($this->lainhargaisipcs->ViewValue, 0, -2, -2, -2);
        $this->lainhargaisipcs->ViewCustomAttributes = "";

        // lainhargaprimerpcs
        $this->lainhargaprimerpcs->ViewValue = $this->lainhargaprimerpcs->CurrentValue;
        $this->lainhargaprimerpcs->ViewValue = FormatNumber($this->lainhargaprimerpcs->ViewValue, 0, -2, -2, -2);
        $this->lainhargaprimerpcs->ViewCustomAttributes = "";

        // lainhargasekunderpcs
        $this->lainhargasekunderpcs->ViewValue = $this->lainhargasekunderpcs->CurrentValue;
        $this->lainhargasekunderpcs->ViewValue = FormatNumber($this->lainhargasekunderpcs->ViewValue, 0, -2, -2, -2);
        $this->lainhargasekunderpcs->ViewCustomAttributes = "";

        // lainhargalabelpcs
        $this->lainhargalabelpcs->ViewValue = $this->lainhargalabelpcs->CurrentValue;
        $this->lainhargalabelpcs->ViewValue = FormatNumber($this->lainhargalabelpcs->ViewValue, 0, -2, -2, -2);
        $this->lainhargalabelpcs->ViewCustomAttributes = "";

        // lainhargatotalpcs
        $this->lainhargatotalpcs->ViewValue = $this->lainhargatotalpcs->CurrentValue;
        $this->lainhargatotalpcs->ViewValue = FormatNumber($this->lainhargatotalpcs->ViewValue, 0, -2, -2, -2);
        $this->lainhargatotalpcs->ViewCustomAttributes = "";

        // lainhargaisiorder
        $this->lainhargaisiorder->ViewValue = $this->lainhargaisiorder->CurrentValue;
        $this->lainhargaisiorder->ViewValue = FormatNumber($this->lainhargaisiorder->ViewValue, 0, -2, -2, -2);
        $this->lainhargaisiorder->ViewCustomAttributes = "";

        // lainhargaprimerorder
        $this->lainhargaprimerorder->ViewValue = $this->lainhargaprimerorder->CurrentValue;
        $this->lainhargaprimerorder->ViewValue = FormatNumber($this->lainhargaprimerorder->ViewValue, 0, -2, -2, -2);
        $this->lainhargaprimerorder->ViewCustomAttributes = "";

        // lainhargasekunderorder
        $this->lainhargasekunderorder->ViewValue = $this->lainhargasekunderorder->CurrentValue;
        $this->lainhargasekunderorder->ViewValue = FormatNumber($this->lainhargasekunderorder->ViewValue, 0, -2, -2, -2);
        $this->lainhargasekunderorder->ViewCustomAttributes = "";

        // lainhargalabelorder
        $this->lainhargalabelorder->ViewValue = $this->lainhargalabelorder->CurrentValue;
        $this->lainhargalabelorder->ViewValue = FormatNumber($this->lainhargalabelorder->ViewValue, 0, -2, -2, -2);
        $this->lainhargalabelorder->ViewCustomAttributes = "";

        // lainhargatotalorder
        $this->lainhargatotalorder->ViewValue = $this->lainhargatotalorder->CurrentValue;
        $this->lainhargatotalorder->ViewValue = FormatNumber($this->lainhargatotalorder->ViewValue, 0, -2, -2, -2);
        $this->lainhargatotalorder->ViewCustomAttributes = "";

        // isibahanaktif
        $this->isibahanaktif->ViewValue = $this->isibahanaktif->CurrentValue;
        $this->isibahanaktif->ViewCustomAttributes = "";

        // isibahanlain
        $this->isibahanlain->ViewValue = $this->isibahanlain->CurrentValue;
        $this->isibahanlain->ViewCustomAttributes = "";

        // isiparfum
        $this->isiparfum->ViewValue = $this->isiparfum->CurrentValue;
        $this->isiparfum->ViewCustomAttributes = "";

        // isiestetika
        $this->isiestetika->ViewValue = $this->isiestetika->CurrentValue;
        $this->isiestetika->ViewCustomAttributes = "";

        // kemasanwadah
        $this->kemasanwadah->ViewValue = $this->kemasanwadah->CurrentValue;
        $this->kemasanwadah->ViewValue = FormatNumber($this->kemasanwadah->ViewValue, 0, -2, -2, -2);
        $this->kemasanwadah->ViewCustomAttributes = "";

        // kemasantutup
        $this->kemasantutup->ViewValue = $this->kemasantutup->CurrentValue;
        $this->kemasantutup->ViewValue = FormatNumber($this->kemasantutup->ViewValue, 0, -2, -2, -2);
        $this->kemasantutup->ViewCustomAttributes = "";

        // kemasansekunder
        $this->kemasansekunder->ViewValue = $this->kemasansekunder->CurrentValue;
        $this->kemasansekunder->ViewCustomAttributes = "";

        // desainlabel
        $this->desainlabel->ViewValue = $this->desainlabel->CurrentValue;
        $this->desainlabel->ViewCustomAttributes = "";

        // cetaklabel
        $this->cetaklabel->ViewValue = $this->cetaklabel->CurrentValue;
        $this->cetaklabel->ViewCustomAttributes = "";

        // lainlain
        $this->lainlain->ViewValue = $this->lainlain->CurrentValue;
        $this->lainlain->ViewCustomAttributes = "";

        // deliverypickup
        $this->deliverypickup->ViewValue = $this->deliverypickup->CurrentValue;
        $this->deliverypickup->ViewCustomAttributes = "";

        // deliverysinglepoint
        $this->deliverysinglepoint->ViewValue = $this->deliverysinglepoint->CurrentValue;
        $this->deliverysinglepoint->ViewCustomAttributes = "";

        // deliverymultipoint
        $this->deliverymultipoint->ViewValue = $this->deliverymultipoint->CurrentValue;
        $this->deliverymultipoint->ViewCustomAttributes = "";

        // deliveryjumlahpoint
        $this->deliveryjumlahpoint->ViewValue = $this->deliveryjumlahpoint->CurrentValue;
        $this->deliveryjumlahpoint->ViewCustomAttributes = "";

        // deliverytermslain
        $this->deliverytermslain->ViewValue = $this->deliverytermslain->CurrentValue;
        $this->deliverytermslain->ViewCustomAttributes = "";

        // catatankhusus
        $this->catatankhusus->ViewValue = $this->catatankhusus->CurrentValue;
        $this->catatankhusus->ViewCustomAttributes = "";

        // dibuatdi
        $this->dibuatdi->ViewValue = $this->dibuatdi->CurrentValue;
        $this->dibuatdi->ViewCustomAttributes = "";

        // tanggal
        $this->tanggal->ViewValue = $this->tanggal->CurrentValue;
        $this->tanggal->ViewValue = FormatDateTime($this->tanggal->ViewValue, 0);
        $this->tanggal->ViewCustomAttributes = "";

        // created_by
        $this->created_by->ViewValue = $this->created_by->CurrentValue;
        $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
        $this->created_by->ViewCustomAttributes = "";

        // id
        $this->id->LinkCustomAttributes = "";
        $this->id->HrefValue = "";
        $this->id->TooltipValue = "";

        // idnpd
        $this->idnpd->LinkCustomAttributes = "";
        $this->idnpd->HrefValue = "";
        $this->idnpd->TooltipValue = "";

        // status
        $this->status->LinkCustomAttributes = "";
        $this->status->HrefValue = "";
        $this->status->TooltipValue = "";

        // tglsubmit
        $this->tglsubmit->LinkCustomAttributes = "";
        $this->tglsubmit->HrefValue = "";
        $this->tglsubmit->TooltipValue = "";

        // sifatorder
        $this->sifatorder->LinkCustomAttributes = "";
        $this->sifatorder->HrefValue = "";
        $this->sifatorder->TooltipValue = "";

        // ukuranutama
        $this->ukuranutama->LinkCustomAttributes = "";
        $this->ukuranutama->HrefValue = "";
        $this->ukuranutama->TooltipValue = "";

        // utamahargaisipcs
        $this->utamahargaisipcs->LinkCustomAttributes = "";
        $this->utamahargaisipcs->HrefValue = "";
        $this->utamahargaisipcs->TooltipValue = "";

        // utamahargaprimerpcs
        $this->utamahargaprimerpcs->LinkCustomAttributes = "";
        $this->utamahargaprimerpcs->HrefValue = "";
        $this->utamahargaprimerpcs->TooltipValue = "";

        // utamahargasekunderpcs
        $this->utamahargasekunderpcs->LinkCustomAttributes = "";
        $this->utamahargasekunderpcs->HrefValue = "";
        $this->utamahargasekunderpcs->TooltipValue = "";

        // utamahargalabelpcs
        $this->utamahargalabelpcs->LinkCustomAttributes = "";
        $this->utamahargalabelpcs->HrefValue = "";
        $this->utamahargalabelpcs->TooltipValue = "";

        // utamahargatotalpcs
        $this->utamahargatotalpcs->LinkCustomAttributes = "";
        $this->utamahargatotalpcs->HrefValue = "";
        $this->utamahargatotalpcs->TooltipValue = "";

        // utamahargaisiorder
        $this->utamahargaisiorder->LinkCustomAttributes = "";
        $this->utamahargaisiorder->HrefValue = "";
        $this->utamahargaisiorder->TooltipValue = "";

        // utamahargaprimerorder
        $this->utamahargaprimerorder->LinkCustomAttributes = "";
        $this->utamahargaprimerorder->HrefValue = "";
        $this->utamahargaprimerorder->TooltipValue = "";

        // utamahargasekunderorder
        $this->utamahargasekunderorder->LinkCustomAttributes = "";
        $this->utamahargasekunderorder->HrefValue = "";
        $this->utamahargasekunderorder->TooltipValue = "";

        // utamahargalabelorder
        $this->utamahargalabelorder->LinkCustomAttributes = "";
        $this->utamahargalabelorder->HrefValue = "";
        $this->utamahargalabelorder->TooltipValue = "";

        // utamahargatotalorder
        $this->utamahargatotalorder->LinkCustomAttributes = "";
        $this->utamahargatotalorder->HrefValue = "";
        $this->utamahargatotalorder->TooltipValue = "";

        // ukuranlain
        $this->ukuranlain->LinkCustomAttributes = "";
        $this->ukuranlain->HrefValue = "";
        $this->ukuranlain->TooltipValue = "";

        // lainhargaisipcs
        $this->lainhargaisipcs->LinkCustomAttributes = "";
        $this->lainhargaisipcs->HrefValue = "";
        $this->lainhargaisipcs->TooltipValue = "";

        // lainhargaprimerpcs
        $this->lainhargaprimerpcs->LinkCustomAttributes = "";
        $this->lainhargaprimerpcs->HrefValue = "";
        $this->lainhargaprimerpcs->TooltipValue = "";

        // lainhargasekunderpcs
        $this->lainhargasekunderpcs->LinkCustomAttributes = "";
        $this->lainhargasekunderpcs->HrefValue = "";
        $this->lainhargasekunderpcs->TooltipValue = "";

        // lainhargalabelpcs
        $this->lainhargalabelpcs->LinkCustomAttributes = "";
        $this->lainhargalabelpcs->HrefValue = "";
        $this->lainhargalabelpcs->TooltipValue = "";

        // lainhargatotalpcs
        $this->lainhargatotalpcs->LinkCustomAttributes = "";
        $this->lainhargatotalpcs->HrefValue = "";
        $this->lainhargatotalpcs->TooltipValue = "";

        // lainhargaisiorder
        $this->lainhargaisiorder->LinkCustomAttributes = "";
        $this->lainhargaisiorder->HrefValue = "";
        $this->lainhargaisiorder->TooltipValue = "";

        // lainhargaprimerorder
        $this->lainhargaprimerorder->LinkCustomAttributes = "";
        $this->lainhargaprimerorder->HrefValue = "";
        $this->lainhargaprimerorder->TooltipValue = "";

        // lainhargasekunderorder
        $this->lainhargasekunderorder->LinkCustomAttributes = "";
        $this->lainhargasekunderorder->HrefValue = "";
        $this->lainhargasekunderorder->TooltipValue = "";

        // lainhargalabelorder
        $this->lainhargalabelorder->LinkCustomAttributes = "";
        $this->lainhargalabelorder->HrefValue = "";
        $this->lainhargalabelorder->TooltipValue = "";

        // lainhargatotalorder
        $this->lainhargatotalorder->LinkCustomAttributes = "";
        $this->lainhargatotalorder->HrefValue = "";
        $this->lainhargatotalorder->TooltipValue = "";

        // isibahanaktif
        $this->isibahanaktif->LinkCustomAttributes = "";
        $this->isibahanaktif->HrefValue = "";
        $this->isibahanaktif->TooltipValue = "";

        // isibahanlain
        $this->isibahanlain->LinkCustomAttributes = "";
        $this->isibahanlain->HrefValue = "";
        $this->isibahanlain->TooltipValue = "";

        // isiparfum
        $this->isiparfum->LinkCustomAttributes = "";
        $this->isiparfum->HrefValue = "";
        $this->isiparfum->TooltipValue = "";

        // isiestetika
        $this->isiestetika->LinkCustomAttributes = "";
        $this->isiestetika->HrefValue = "";
        $this->isiestetika->TooltipValue = "";

        // kemasanwadah
        $this->kemasanwadah->LinkCustomAttributes = "";
        $this->kemasanwadah->HrefValue = "";
        $this->kemasanwadah->TooltipValue = "";

        // kemasantutup
        $this->kemasantutup->LinkCustomAttributes = "";
        $this->kemasantutup->HrefValue = "";
        $this->kemasantutup->TooltipValue = "";

        // kemasansekunder
        $this->kemasansekunder->LinkCustomAttributes = "";
        $this->kemasansekunder->HrefValue = "";
        $this->kemasansekunder->TooltipValue = "";

        // desainlabel
        $this->desainlabel->LinkCustomAttributes = "";
        $this->desainlabel->HrefValue = "";
        $this->desainlabel->TooltipValue = "";

        // cetaklabel
        $this->cetaklabel->LinkCustomAttributes = "";
        $this->cetaklabel->HrefValue = "";
        $this->cetaklabel->TooltipValue = "";

        // lainlain
        $this->lainlain->LinkCustomAttributes = "";
        $this->lainlain->HrefValue = "";
        $this->lainlain->TooltipValue = "";

        // deliverypickup
        $this->deliverypickup->LinkCustomAttributes = "";
        $this->deliverypickup->HrefValue = "";
        $this->deliverypickup->TooltipValue = "";

        // deliverysinglepoint
        $this->deliverysinglepoint->LinkCustomAttributes = "";
        $this->deliverysinglepoint->HrefValue = "";
        $this->deliverysinglepoint->TooltipValue = "";

        // deliverymultipoint
        $this->deliverymultipoint->LinkCustomAttributes = "";
        $this->deliverymultipoint->HrefValue = "";
        $this->deliverymultipoint->TooltipValue = "";

        // deliveryjumlahpoint
        $this->deliveryjumlahpoint->LinkCustomAttributes = "";
        $this->deliveryjumlahpoint->HrefValue = "";
        $this->deliveryjumlahpoint->TooltipValue = "";

        // deliverytermslain
        $this->deliverytermslain->LinkCustomAttributes = "";
        $this->deliverytermslain->HrefValue = "";
        $this->deliverytermslain->TooltipValue = "";

        // catatankhusus
        $this->catatankhusus->LinkCustomAttributes = "";
        $this->catatankhusus->HrefValue = "";
        $this->catatankhusus->TooltipValue = "";

        // dibuatdi
        $this->dibuatdi->LinkCustomAttributes = "";
        $this->dibuatdi->HrefValue = "";
        $this->dibuatdi->TooltipValue = "";

        // tanggal
        $this->tanggal->LinkCustomAttributes = "";
        $this->tanggal->HrefValue = "";
        $this->tanggal->TooltipValue = "";

        // created_by
        $this->created_by->LinkCustomAttributes = "";
        $this->created_by->HrefValue = "";
        $this->created_by->TooltipValue = "";

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

        // idnpd
        $this->idnpd->EditAttrs["class"] = "form-control";
        $this->idnpd->EditCustomAttributes = "";
        $this->idnpd->EditValue = $this->idnpd->CurrentValue;
        $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());

        // status
        $this->status->EditAttrs["class"] = "form-control";
        $this->status->EditCustomAttributes = "";
        if (!$this->status->Raw) {
            $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
        }
        $this->status->EditValue = $this->status->CurrentValue;
        $this->status->PlaceHolder = RemoveHtml($this->status->caption());

        // tglsubmit
        $this->tglsubmit->EditAttrs["class"] = "form-control";
        $this->tglsubmit->EditCustomAttributes = "";
        $this->tglsubmit->EditValue = FormatDateTime($this->tglsubmit->CurrentValue, 8);
        $this->tglsubmit->PlaceHolder = RemoveHtml($this->tglsubmit->caption());

        // sifatorder
        $this->sifatorder->EditCustomAttributes = "";
        $this->sifatorder->EditValue = $this->sifatorder->options(false);
        $this->sifatorder->PlaceHolder = RemoveHtml($this->sifatorder->caption());

        // ukuranutama
        $this->ukuranutama->EditAttrs["class"] = "form-control";
        $this->ukuranutama->EditCustomAttributes = "";
        if (!$this->ukuranutama->Raw) {
            $this->ukuranutama->CurrentValue = HtmlDecode($this->ukuranutama->CurrentValue);
        }
        $this->ukuranutama->EditValue = $this->ukuranutama->CurrentValue;
        $this->ukuranutama->PlaceHolder = RemoveHtml($this->ukuranutama->caption());

        // utamahargaisipcs
        $this->utamahargaisipcs->EditAttrs["class"] = "form-control";
        $this->utamahargaisipcs->EditCustomAttributes = "";
        $this->utamahargaisipcs->EditValue = $this->utamahargaisipcs->CurrentValue;
        $this->utamahargaisipcs->PlaceHolder = RemoveHtml($this->utamahargaisipcs->caption());

        // utamahargaprimerpcs
        $this->utamahargaprimerpcs->EditAttrs["class"] = "form-control";
        $this->utamahargaprimerpcs->EditCustomAttributes = "";
        $this->utamahargaprimerpcs->EditValue = $this->utamahargaprimerpcs->CurrentValue;
        $this->utamahargaprimerpcs->PlaceHolder = RemoveHtml($this->utamahargaprimerpcs->caption());

        // utamahargasekunderpcs
        $this->utamahargasekunderpcs->EditAttrs["class"] = "form-control";
        $this->utamahargasekunderpcs->EditCustomAttributes = "";
        $this->utamahargasekunderpcs->EditValue = $this->utamahargasekunderpcs->CurrentValue;
        $this->utamahargasekunderpcs->PlaceHolder = RemoveHtml($this->utamahargasekunderpcs->caption());

        // utamahargalabelpcs
        $this->utamahargalabelpcs->EditAttrs["class"] = "form-control";
        $this->utamahargalabelpcs->EditCustomAttributes = "";
        $this->utamahargalabelpcs->EditValue = $this->utamahargalabelpcs->CurrentValue;
        $this->utamahargalabelpcs->PlaceHolder = RemoveHtml($this->utamahargalabelpcs->caption());

        // utamahargatotalpcs
        $this->utamahargatotalpcs->EditAttrs["class"] = "form-control";
        $this->utamahargatotalpcs->EditCustomAttributes = "";
        $this->utamahargatotalpcs->EditValue = $this->utamahargatotalpcs->CurrentValue;
        $this->utamahargatotalpcs->PlaceHolder = RemoveHtml($this->utamahargatotalpcs->caption());

        // utamahargaisiorder
        $this->utamahargaisiorder->EditAttrs["class"] = "form-control";
        $this->utamahargaisiorder->EditCustomAttributes = "";
        $this->utamahargaisiorder->EditValue = $this->utamahargaisiorder->CurrentValue;
        $this->utamahargaisiorder->PlaceHolder = RemoveHtml($this->utamahargaisiorder->caption());

        // utamahargaprimerorder
        $this->utamahargaprimerorder->EditAttrs["class"] = "form-control";
        $this->utamahargaprimerorder->EditCustomAttributes = "";
        $this->utamahargaprimerorder->EditValue = $this->utamahargaprimerorder->CurrentValue;
        $this->utamahargaprimerorder->PlaceHolder = RemoveHtml($this->utamahargaprimerorder->caption());

        // utamahargasekunderorder
        $this->utamahargasekunderorder->EditAttrs["class"] = "form-control";
        $this->utamahargasekunderorder->EditCustomAttributes = "";
        $this->utamahargasekunderorder->EditValue = $this->utamahargasekunderorder->CurrentValue;
        $this->utamahargasekunderorder->PlaceHolder = RemoveHtml($this->utamahargasekunderorder->caption());

        // utamahargalabelorder
        $this->utamahargalabelorder->EditAttrs["class"] = "form-control";
        $this->utamahargalabelorder->EditCustomAttributes = "";
        $this->utamahargalabelorder->EditValue = $this->utamahargalabelorder->CurrentValue;
        $this->utamahargalabelorder->PlaceHolder = RemoveHtml($this->utamahargalabelorder->caption());

        // utamahargatotalorder
        $this->utamahargatotalorder->EditAttrs["class"] = "form-control";
        $this->utamahargatotalorder->EditCustomAttributes = "";
        $this->utamahargatotalorder->EditValue = $this->utamahargatotalorder->CurrentValue;
        $this->utamahargatotalorder->PlaceHolder = RemoveHtml($this->utamahargatotalorder->caption());

        // ukuranlain
        $this->ukuranlain->EditAttrs["class"] = "form-control";
        $this->ukuranlain->EditCustomAttributes = "";
        if (!$this->ukuranlain->Raw) {
            $this->ukuranlain->CurrentValue = HtmlDecode($this->ukuranlain->CurrentValue);
        }
        $this->ukuranlain->EditValue = $this->ukuranlain->CurrentValue;
        $this->ukuranlain->PlaceHolder = RemoveHtml($this->ukuranlain->caption());

        // lainhargaisipcs
        $this->lainhargaisipcs->EditAttrs["class"] = "form-control";
        $this->lainhargaisipcs->EditCustomAttributes = "";
        $this->lainhargaisipcs->EditValue = $this->lainhargaisipcs->CurrentValue;
        $this->lainhargaisipcs->PlaceHolder = RemoveHtml($this->lainhargaisipcs->caption());

        // lainhargaprimerpcs
        $this->lainhargaprimerpcs->EditAttrs["class"] = "form-control";
        $this->lainhargaprimerpcs->EditCustomAttributes = "";
        $this->lainhargaprimerpcs->EditValue = $this->lainhargaprimerpcs->CurrentValue;
        $this->lainhargaprimerpcs->PlaceHolder = RemoveHtml($this->lainhargaprimerpcs->caption());

        // lainhargasekunderpcs
        $this->lainhargasekunderpcs->EditAttrs["class"] = "form-control";
        $this->lainhargasekunderpcs->EditCustomAttributes = "";
        $this->lainhargasekunderpcs->EditValue = $this->lainhargasekunderpcs->CurrentValue;
        $this->lainhargasekunderpcs->PlaceHolder = RemoveHtml($this->lainhargasekunderpcs->caption());

        // lainhargalabelpcs
        $this->lainhargalabelpcs->EditAttrs["class"] = "form-control";
        $this->lainhargalabelpcs->EditCustomAttributes = "";
        $this->lainhargalabelpcs->EditValue = $this->lainhargalabelpcs->CurrentValue;
        $this->lainhargalabelpcs->PlaceHolder = RemoveHtml($this->lainhargalabelpcs->caption());

        // lainhargatotalpcs
        $this->lainhargatotalpcs->EditAttrs["class"] = "form-control";
        $this->lainhargatotalpcs->EditCustomAttributes = "";
        $this->lainhargatotalpcs->EditValue = $this->lainhargatotalpcs->CurrentValue;
        $this->lainhargatotalpcs->PlaceHolder = RemoveHtml($this->lainhargatotalpcs->caption());

        // lainhargaisiorder
        $this->lainhargaisiorder->EditAttrs["class"] = "form-control";
        $this->lainhargaisiorder->EditCustomAttributes = "";
        $this->lainhargaisiorder->EditValue = $this->lainhargaisiorder->CurrentValue;
        $this->lainhargaisiorder->PlaceHolder = RemoveHtml($this->lainhargaisiorder->caption());

        // lainhargaprimerorder
        $this->lainhargaprimerorder->EditAttrs["class"] = "form-control";
        $this->lainhargaprimerorder->EditCustomAttributes = "";
        $this->lainhargaprimerorder->EditValue = $this->lainhargaprimerorder->CurrentValue;
        $this->lainhargaprimerorder->PlaceHolder = RemoveHtml($this->lainhargaprimerorder->caption());

        // lainhargasekunderorder
        $this->lainhargasekunderorder->EditAttrs["class"] = "form-control";
        $this->lainhargasekunderorder->EditCustomAttributes = "";
        $this->lainhargasekunderorder->EditValue = $this->lainhargasekunderorder->CurrentValue;
        $this->lainhargasekunderorder->PlaceHolder = RemoveHtml($this->lainhargasekunderorder->caption());

        // lainhargalabelorder
        $this->lainhargalabelorder->EditAttrs["class"] = "form-control";
        $this->lainhargalabelorder->EditCustomAttributes = "";
        $this->lainhargalabelorder->EditValue = $this->lainhargalabelorder->CurrentValue;
        $this->lainhargalabelorder->PlaceHolder = RemoveHtml($this->lainhargalabelorder->caption());

        // lainhargatotalorder
        $this->lainhargatotalorder->EditAttrs["class"] = "form-control";
        $this->lainhargatotalorder->EditCustomAttributes = "";
        $this->lainhargatotalorder->EditValue = $this->lainhargatotalorder->CurrentValue;
        $this->lainhargatotalorder->PlaceHolder = RemoveHtml($this->lainhargatotalorder->caption());

        // isibahanaktif
        $this->isibahanaktif->EditAttrs["class"] = "form-control";
        $this->isibahanaktif->EditCustomAttributes = "";
        if (!$this->isibahanaktif->Raw) {
            $this->isibahanaktif->CurrentValue = HtmlDecode($this->isibahanaktif->CurrentValue);
        }
        $this->isibahanaktif->EditValue = $this->isibahanaktif->CurrentValue;
        $this->isibahanaktif->PlaceHolder = RemoveHtml($this->isibahanaktif->caption());

        // isibahanlain
        $this->isibahanlain->EditAttrs["class"] = "form-control";
        $this->isibahanlain->EditCustomAttributes = "";
        if (!$this->isibahanlain->Raw) {
            $this->isibahanlain->CurrentValue = HtmlDecode($this->isibahanlain->CurrentValue);
        }
        $this->isibahanlain->EditValue = $this->isibahanlain->CurrentValue;
        $this->isibahanlain->PlaceHolder = RemoveHtml($this->isibahanlain->caption());

        // isiparfum
        $this->isiparfum->EditAttrs["class"] = "form-control";
        $this->isiparfum->EditCustomAttributes = "";
        if (!$this->isiparfum->Raw) {
            $this->isiparfum->CurrentValue = HtmlDecode($this->isiparfum->CurrentValue);
        }
        $this->isiparfum->EditValue = $this->isiparfum->CurrentValue;
        $this->isiparfum->PlaceHolder = RemoveHtml($this->isiparfum->caption());

        // isiestetika
        $this->isiestetika->EditAttrs["class"] = "form-control";
        $this->isiestetika->EditCustomAttributes = "";
        if (!$this->isiestetika->Raw) {
            $this->isiestetika->CurrentValue = HtmlDecode($this->isiestetika->CurrentValue);
        }
        $this->isiestetika->EditValue = $this->isiestetika->CurrentValue;
        $this->isiestetika->PlaceHolder = RemoveHtml($this->isiestetika->caption());

        // kemasanwadah
        $this->kemasanwadah->EditAttrs["class"] = "form-control";
        $this->kemasanwadah->EditCustomAttributes = "";
        $this->kemasanwadah->EditValue = $this->kemasanwadah->CurrentValue;
        $this->kemasanwadah->PlaceHolder = RemoveHtml($this->kemasanwadah->caption());

        // kemasantutup
        $this->kemasantutup->EditAttrs["class"] = "form-control";
        $this->kemasantutup->EditCustomAttributes = "";
        $this->kemasantutup->EditValue = $this->kemasantutup->CurrentValue;
        $this->kemasantutup->PlaceHolder = RemoveHtml($this->kemasantutup->caption());

        // kemasansekunder
        $this->kemasansekunder->EditAttrs["class"] = "form-control";
        $this->kemasansekunder->EditCustomAttributes = "";
        if (!$this->kemasansekunder->Raw) {
            $this->kemasansekunder->CurrentValue = HtmlDecode($this->kemasansekunder->CurrentValue);
        }
        $this->kemasansekunder->EditValue = $this->kemasansekunder->CurrentValue;
        $this->kemasansekunder->PlaceHolder = RemoveHtml($this->kemasansekunder->caption());

        // desainlabel
        $this->desainlabel->EditAttrs["class"] = "form-control";
        $this->desainlabel->EditCustomAttributes = "";
        if (!$this->desainlabel->Raw) {
            $this->desainlabel->CurrentValue = HtmlDecode($this->desainlabel->CurrentValue);
        }
        $this->desainlabel->EditValue = $this->desainlabel->CurrentValue;
        $this->desainlabel->PlaceHolder = RemoveHtml($this->desainlabel->caption());

        // cetaklabel
        $this->cetaklabel->EditAttrs["class"] = "form-control";
        $this->cetaklabel->EditCustomAttributes = "";
        if (!$this->cetaklabel->Raw) {
            $this->cetaklabel->CurrentValue = HtmlDecode($this->cetaklabel->CurrentValue);
        }
        $this->cetaklabel->EditValue = $this->cetaklabel->CurrentValue;
        $this->cetaklabel->PlaceHolder = RemoveHtml($this->cetaklabel->caption());

        // lainlain
        $this->lainlain->EditAttrs["class"] = "form-control";
        $this->lainlain->EditCustomAttributes = "";
        if (!$this->lainlain->Raw) {
            $this->lainlain->CurrentValue = HtmlDecode($this->lainlain->CurrentValue);
        }
        $this->lainlain->EditValue = $this->lainlain->CurrentValue;
        $this->lainlain->PlaceHolder = RemoveHtml($this->lainlain->caption());

        // deliverypickup
        $this->deliverypickup->EditAttrs["class"] = "form-control";
        $this->deliverypickup->EditCustomAttributes = "";
        if (!$this->deliverypickup->Raw) {
            $this->deliverypickup->CurrentValue = HtmlDecode($this->deliverypickup->CurrentValue);
        }
        $this->deliverypickup->EditValue = $this->deliverypickup->CurrentValue;
        $this->deliverypickup->PlaceHolder = RemoveHtml($this->deliverypickup->caption());

        // deliverysinglepoint
        $this->deliverysinglepoint->EditAttrs["class"] = "form-control";
        $this->deliverysinglepoint->EditCustomAttributes = "";
        if (!$this->deliverysinglepoint->Raw) {
            $this->deliverysinglepoint->CurrentValue = HtmlDecode($this->deliverysinglepoint->CurrentValue);
        }
        $this->deliverysinglepoint->EditValue = $this->deliverysinglepoint->CurrentValue;
        $this->deliverysinglepoint->PlaceHolder = RemoveHtml($this->deliverysinglepoint->caption());

        // deliverymultipoint
        $this->deliverymultipoint->EditAttrs["class"] = "form-control";
        $this->deliverymultipoint->EditCustomAttributes = "";
        if (!$this->deliverymultipoint->Raw) {
            $this->deliverymultipoint->CurrentValue = HtmlDecode($this->deliverymultipoint->CurrentValue);
        }
        $this->deliverymultipoint->EditValue = $this->deliverymultipoint->CurrentValue;
        $this->deliverymultipoint->PlaceHolder = RemoveHtml($this->deliverymultipoint->caption());

        // deliveryjumlahpoint
        $this->deliveryjumlahpoint->EditAttrs["class"] = "form-control";
        $this->deliveryjumlahpoint->EditCustomAttributes = "";
        if (!$this->deliveryjumlahpoint->Raw) {
            $this->deliveryjumlahpoint->CurrentValue = HtmlDecode($this->deliveryjumlahpoint->CurrentValue);
        }
        $this->deliveryjumlahpoint->EditValue = $this->deliveryjumlahpoint->CurrentValue;
        $this->deliveryjumlahpoint->PlaceHolder = RemoveHtml($this->deliveryjumlahpoint->caption());

        // deliverytermslain
        $this->deliverytermslain->EditAttrs["class"] = "form-control";
        $this->deliverytermslain->EditCustomAttributes = "";
        if (!$this->deliverytermslain->Raw) {
            $this->deliverytermslain->CurrentValue = HtmlDecode($this->deliverytermslain->CurrentValue);
        }
        $this->deliverytermslain->EditValue = $this->deliverytermslain->CurrentValue;
        $this->deliverytermslain->PlaceHolder = RemoveHtml($this->deliverytermslain->caption());

        // catatankhusus
        $this->catatankhusus->EditAttrs["class"] = "form-control";
        $this->catatankhusus->EditCustomAttributes = "";
        if (!$this->catatankhusus->Raw) {
            $this->catatankhusus->CurrentValue = HtmlDecode($this->catatankhusus->CurrentValue);
        }
        $this->catatankhusus->EditValue = $this->catatankhusus->CurrentValue;
        $this->catatankhusus->PlaceHolder = RemoveHtml($this->catatankhusus->caption());

        // dibuatdi
        $this->dibuatdi->EditAttrs["class"] = "form-control";
        $this->dibuatdi->EditCustomAttributes = "";
        if (!$this->dibuatdi->Raw) {
            $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
        }
        $this->dibuatdi->EditValue = $this->dibuatdi->CurrentValue;
        $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

        // tanggal
        $this->tanggal->EditAttrs["class"] = "form-control";
        $this->tanggal->EditCustomAttributes = "";
        $this->tanggal->EditValue = FormatDateTime($this->tanggal->CurrentValue, 8);
        $this->tanggal->PlaceHolder = RemoveHtml($this->tanggal->caption());

        // created_by
        $this->created_by->EditAttrs["class"] = "form-control";
        $this->created_by->EditCustomAttributes = "";
        $this->created_by->EditValue = $this->created_by->CurrentValue;
        $this->created_by->PlaceHolder = RemoveHtml($this->created_by->caption());

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
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->sifatorder);
                    $doc->exportCaption($this->ukuranutama);
                    $doc->exportCaption($this->utamahargaisipcs);
                    $doc->exportCaption($this->utamahargaprimerpcs);
                    $doc->exportCaption($this->utamahargasekunderpcs);
                    $doc->exportCaption($this->utamahargalabelpcs);
                    $doc->exportCaption($this->utamahargatotalpcs);
                    $doc->exportCaption($this->utamahargaisiorder);
                    $doc->exportCaption($this->utamahargaprimerorder);
                    $doc->exportCaption($this->utamahargasekunderorder);
                    $doc->exportCaption($this->utamahargalabelorder);
                    $doc->exportCaption($this->utamahargatotalorder);
                    $doc->exportCaption($this->ukuranlain);
                    $doc->exportCaption($this->lainhargaisipcs);
                    $doc->exportCaption($this->lainhargaprimerpcs);
                    $doc->exportCaption($this->lainhargasekunderpcs);
                    $doc->exportCaption($this->lainhargalabelpcs);
                    $doc->exportCaption($this->lainhargatotalpcs);
                    $doc->exportCaption($this->lainhargaisiorder);
                    $doc->exportCaption($this->lainhargaprimerorder);
                    $doc->exportCaption($this->lainhargasekunderorder);
                    $doc->exportCaption($this->lainhargalabelorder);
                    $doc->exportCaption($this->lainhargatotalorder);
                    $doc->exportCaption($this->isibahanaktif);
                    $doc->exportCaption($this->isibahanlain);
                    $doc->exportCaption($this->isiparfum);
                    $doc->exportCaption($this->isiestetika);
                    $doc->exportCaption($this->kemasanwadah);
                    $doc->exportCaption($this->kemasantutup);
                    $doc->exportCaption($this->kemasansekunder);
                    $doc->exportCaption($this->desainlabel);
                    $doc->exportCaption($this->cetaklabel);
                    $doc->exportCaption($this->lainlain);
                    $doc->exportCaption($this->deliverypickup);
                    $doc->exportCaption($this->deliverysinglepoint);
                    $doc->exportCaption($this->deliverymultipoint);
                    $doc->exportCaption($this->deliveryjumlahpoint);
                    $doc->exportCaption($this->deliverytermslain);
                    $doc->exportCaption($this->catatankhusus);
                    $doc->exportCaption($this->dibuatdi);
                    $doc->exportCaption($this->tanggal);
                    $doc->exportCaption($this->created_by);
                } else {
                    $doc->exportCaption($this->id);
                    $doc->exportCaption($this->idnpd);
                    $doc->exportCaption($this->status);
                    $doc->exportCaption($this->tglsubmit);
                    $doc->exportCaption($this->sifatorder);
                    $doc->exportCaption($this->ukuranutama);
                    $doc->exportCaption($this->utamahargaisipcs);
                    $doc->exportCaption($this->utamahargaprimerpcs);
                    $doc->exportCaption($this->utamahargasekunderpcs);
                    $doc->exportCaption($this->utamahargalabelpcs);
                    $doc->exportCaption($this->utamahargatotalpcs);
                    $doc->exportCaption($this->utamahargaisiorder);
                    $doc->exportCaption($this->utamahargaprimerorder);
                    $doc->exportCaption($this->utamahargasekunderorder);
                    $doc->exportCaption($this->utamahargalabelorder);
                    $doc->exportCaption($this->utamahargatotalorder);
                    $doc->exportCaption($this->ukuranlain);
                    $doc->exportCaption($this->lainhargaisipcs);
                    $doc->exportCaption($this->lainhargaprimerpcs);
                    $doc->exportCaption($this->lainhargasekunderpcs);
                    $doc->exportCaption($this->lainhargalabelpcs);
                    $doc->exportCaption($this->lainhargatotalpcs);
                    $doc->exportCaption($this->lainhargaisiorder);
                    $doc->exportCaption($this->lainhargaprimerorder);
                    $doc->exportCaption($this->lainhargasekunderorder);
                    $doc->exportCaption($this->lainhargalabelorder);
                    $doc->exportCaption($this->lainhargatotalorder);
                    $doc->exportCaption($this->isibahanaktif);
                    $doc->exportCaption($this->isibahanlain);
                    $doc->exportCaption($this->isiparfum);
                    $doc->exportCaption($this->isiestetika);
                    $doc->exportCaption($this->kemasanwadah);
                    $doc->exportCaption($this->kemasantutup);
                    $doc->exportCaption($this->kemasansekunder);
                    $doc->exportCaption($this->desainlabel);
                    $doc->exportCaption($this->cetaklabel);
                    $doc->exportCaption($this->lainlain);
                    $doc->exportCaption($this->deliverypickup);
                    $doc->exportCaption($this->deliverysinglepoint);
                    $doc->exportCaption($this->deliverymultipoint);
                    $doc->exportCaption($this->deliveryjumlahpoint);
                    $doc->exportCaption($this->deliverytermslain);
                    $doc->exportCaption($this->catatankhusus);
                    $doc->exportCaption($this->dibuatdi);
                    $doc->exportCaption($this->tanggal);
                    $doc->exportCaption($this->created_by);
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
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->status);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->sifatorder);
                        $doc->exportField($this->ukuranutama);
                        $doc->exportField($this->utamahargaisipcs);
                        $doc->exportField($this->utamahargaprimerpcs);
                        $doc->exportField($this->utamahargasekunderpcs);
                        $doc->exportField($this->utamahargalabelpcs);
                        $doc->exportField($this->utamahargatotalpcs);
                        $doc->exportField($this->utamahargaisiorder);
                        $doc->exportField($this->utamahargaprimerorder);
                        $doc->exportField($this->utamahargasekunderorder);
                        $doc->exportField($this->utamahargalabelorder);
                        $doc->exportField($this->utamahargatotalorder);
                        $doc->exportField($this->ukuranlain);
                        $doc->exportField($this->lainhargaisipcs);
                        $doc->exportField($this->lainhargaprimerpcs);
                        $doc->exportField($this->lainhargasekunderpcs);
                        $doc->exportField($this->lainhargalabelpcs);
                        $doc->exportField($this->lainhargatotalpcs);
                        $doc->exportField($this->lainhargaisiorder);
                        $doc->exportField($this->lainhargaprimerorder);
                        $doc->exportField($this->lainhargasekunderorder);
                        $doc->exportField($this->lainhargalabelorder);
                        $doc->exportField($this->lainhargatotalorder);
                        $doc->exportField($this->isibahanaktif);
                        $doc->exportField($this->isibahanlain);
                        $doc->exportField($this->isiparfum);
                        $doc->exportField($this->isiestetika);
                        $doc->exportField($this->kemasanwadah);
                        $doc->exportField($this->kemasantutup);
                        $doc->exportField($this->kemasansekunder);
                        $doc->exportField($this->desainlabel);
                        $doc->exportField($this->cetaklabel);
                        $doc->exportField($this->lainlain);
                        $doc->exportField($this->deliverypickup);
                        $doc->exportField($this->deliverysinglepoint);
                        $doc->exportField($this->deliverymultipoint);
                        $doc->exportField($this->deliveryjumlahpoint);
                        $doc->exportField($this->deliverytermslain);
                        $doc->exportField($this->catatankhusus);
                        $doc->exportField($this->dibuatdi);
                        $doc->exportField($this->tanggal);
                        $doc->exportField($this->created_by);
                    } else {
                        $doc->exportField($this->id);
                        $doc->exportField($this->idnpd);
                        $doc->exportField($this->status);
                        $doc->exportField($this->tglsubmit);
                        $doc->exportField($this->sifatorder);
                        $doc->exportField($this->ukuranutama);
                        $doc->exportField($this->utamahargaisipcs);
                        $doc->exportField($this->utamahargaprimerpcs);
                        $doc->exportField($this->utamahargasekunderpcs);
                        $doc->exportField($this->utamahargalabelpcs);
                        $doc->exportField($this->utamahargatotalpcs);
                        $doc->exportField($this->utamahargaisiorder);
                        $doc->exportField($this->utamahargaprimerorder);
                        $doc->exportField($this->utamahargasekunderorder);
                        $doc->exportField($this->utamahargalabelorder);
                        $doc->exportField($this->utamahargatotalorder);
                        $doc->exportField($this->ukuranlain);
                        $doc->exportField($this->lainhargaisipcs);
                        $doc->exportField($this->lainhargaprimerpcs);
                        $doc->exportField($this->lainhargasekunderpcs);
                        $doc->exportField($this->lainhargalabelpcs);
                        $doc->exportField($this->lainhargatotalpcs);
                        $doc->exportField($this->lainhargaisiorder);
                        $doc->exportField($this->lainhargaprimerorder);
                        $doc->exportField($this->lainhargasekunderorder);
                        $doc->exportField($this->lainhargalabelorder);
                        $doc->exportField($this->lainhargatotalorder);
                        $doc->exportField($this->isibahanaktif);
                        $doc->exportField($this->isibahanlain);
                        $doc->exportField($this->isiparfum);
                        $doc->exportField($this->isiestetika);
                        $doc->exportField($this->kemasanwadah);
                        $doc->exportField($this->kemasantutup);
                        $doc->exportField($this->kemasansekunder);
                        $doc->exportField($this->desainlabel);
                        $doc->exportField($this->cetaklabel);
                        $doc->exportField($this->lainlain);
                        $doc->exportField($this->deliverypickup);
                        $doc->exportField($this->deliverysinglepoint);
                        $doc->exportField($this->deliverymultipoint);
                        $doc->exportField($this->deliveryjumlahpoint);
                        $doc->exportField($this->deliverytermslain);
                        $doc->exportField($this->catatankhusus);
                        $doc->exportField($this->dibuatdi);
                        $doc->exportField($this->tanggal);
                        $doc->exportField($this->created_by);
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
