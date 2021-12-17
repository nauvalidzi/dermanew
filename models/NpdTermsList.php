<?php

namespace PHPMaker2021\Dermateknonew;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdTermsList extends NpdTerms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "list";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_terms';

    // Page object name
    public $PageObjName = "NpdTermsList";

    // Rendering View
    public $RenderingView = false;

    // Grid form hidden field names
    public $FormName = "fnpd_termslist";
    public $FormActionName = "k_action";
    public $FormBlankRowName = "k_blankrow";
    public $FormKeyCountName = "key_count";

    // Page URLs
    public $AddUrl;
    public $EditUrl;
    public $CopyUrl;
    public $DeleteUrl;
    public $ViewUrl;
    public $ListUrl;

    // Export URLs
    public $ExportPrintUrl;
    public $ExportHtmlUrl;
    public $ExportExcelUrl;
    public $ExportWordUrl;
    public $ExportXmlUrl;
    public $ExportCsvUrl;
    public $ExportPdfUrl;

    // Custom export
    public $ExportExcelCustom = false;
    public $ExportWordCustom = false;
    public $ExportPdfCustom = false;
    public $ExportEmailCustom = false;

    // Update URLs
    public $InlineAddUrl;
    public $InlineCopyUrl;
    public $InlineEditUrl;
    public $GridAddUrl;
    public $GridEditUrl;
    public $MultiDeleteUrl;
    public $MultiUpdateUrl;

    // Page headings
    public $Heading = "";
    public $Subheading = "";
    public $PageHeader;
    public $PageFooter;

    // Page terminated
    private $terminated = false;

    // Page heading
    public function pageHeading()
    {
        global $Language;
        if ($this->Heading != "") {
            return $this->Heading;
        }
        if (method_exists($this, "tableCaption")) {
            return $this->tableCaption();
        }
        return "";
    }

    // Page subheading
    public function pageSubheading()
    {
        global $Language;
        if ($this->Subheading != "") {
            return $this->Subheading;
        }
        if ($this->TableName) {
            return $Language->phrase($this->PageID);
        }
        return "";
    }

    // Page name
    public function pageName()
    {
        return CurrentPageName();
    }

    // Page URL
    public function pageUrl()
    {
        $url = ScriptName() . "?";
        if ($this->UseTokenInUrl) {
            $url .= "t=" . $this->TableVar . "&"; // Add page token
        }
        return $url;
    }

    // Show Page Header
    public function showPageHeader()
    {
        $header = $this->PageHeader;
        $this->pageDataRendering($header);
        if ($header != "") { // Header exists, display
            echo '<p id="ew-page-header">' . $header . '</p>';
        }
    }

    // Show Page Footer
    public function showPageFooter()
    {
        $footer = $this->PageFooter;
        $this->pageDataRendered($footer);
        if ($footer != "") { // Footer exists, display
            echo '<p id="ew-page-footer">' . $footer . '</p>';
        }
    }

    // Validate page request
    protected function isPageRequest()
    {
        global $CurrentForm;
        if ($this->UseTokenInUrl) {
            if ($CurrentForm) {
                return ($this->TableVar == $CurrentForm->getValue("t"));
            }
            if (Get("t") !== null) {
                return ($this->TableVar == Get("t"));
            }
        }
        return true;
    }

    // Constructor
    public function __construct()
    {
        global $Language, $DashboardReport, $DebugTimer;
        global $UserTable;

        // Initialize
        $GLOBALS["Page"] = &$this;

        // Language object
        $Language = Container("language");

        // Parent constuctor
        parent::__construct();

        // Table object (npd_terms)
        if (!isset($GLOBALS["npd_terms"]) || get_class($GLOBALS["npd_terms"]) == PROJECT_NAMESPACE . "npd_terms") {
            $GLOBALS["npd_terms"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();

        // Initialize URLs
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->AddUrl = "NpdTermsAdd";
        $this->InlineAddUrl = $pageUrl . "action=add";
        $this->GridAddUrl = $pageUrl . "action=gridadd";
        $this->GridEditUrl = $pageUrl . "action=gridedit";
        $this->MultiDeleteUrl = "NpdTermsDelete";
        $this->MultiUpdateUrl = "NpdTermsUpdate";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_terms');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // List options
        $this->ListOptions = new ListOptions();
        $this->ListOptions->TableVar = $this->TableVar;

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Import options
        $this->ImportOptions = new ListOptions("div");
        $this->ImportOptions->TagClassName = "ew-import-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["addedit"] = new ListOptions("div");
        $this->OtherOptions["addedit"]->TagClassName = "ew-add-edit-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";

        // Filter options
        $this->FilterOptions = new ListOptions("div");
        $this->FilterOptions->TagClassName = "ew-filter-option fnpd_termslistsrch";

        // List actions
        $this->ListActions = new ListActions();
    }

    // Get content from stream
    public function getContents($stream = null): string
    {
        global $Response;
        return is_object($Response) ? $Response->getBody() : ob_get_clean();
    }

    // Is lookup
    public function isLookup()
    {
        return SameText(Route(0), Config("API_LOOKUP_ACTION"));
    }

    // Is AutoFill
    public function isAutoFill()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autofill");
    }

    // Is AutoSuggest
    public function isAutoSuggest()
    {
        return $this->isLookup() && SameText(Post("ajax"), "autosuggest");
    }

    // Is modal lookup
    public function isModalLookup()
    {
        return $this->isLookup() && SameText(Post("ajax"), "modal");
    }

    // Is terminated
    public function isTerminated()
    {
        return $this->terminated;
    }

    /**
     * Terminate page
     *
     * @param string $url URL for direction
     * @return void
     */
    public function terminate($url = "")
    {
        if ($this->terminated) {
            return;
        }
        global $ExportFileName, $TempImages, $DashboardReport, $Response;

        // Page is terminated
        $this->terminated = true;

         // Page Unload event
        if (method_exists($this, "pageUnload")) {
            $this->pageUnload();
        }

        // Global Page Unloaded event (in userfn*.php)
        Page_Unloaded();

        // Export
        if ($this->CustomExport && $this->CustomExport == $this->Export && array_key_exists($this->CustomExport, Config("EXPORT_CLASSES"))) {
            $content = $this->getContents();
            if ($ExportFileName == "") {
                $ExportFileName = $this->TableVar;
            }
            $class = PROJECT_NAMESPACE . Config("EXPORT_CLASSES." . $this->CustomExport);
            if (class_exists($class)) {
                $doc = new $class(Container("npd_terms"));
                $doc->Text = @$content;
                if ($this->isExport("email")) {
                    echo $this->exportEmail($doc->Text);
                } else {
                    $doc->export();
                }
                DeleteTempImages(); // Delete temp images
                return;
            }
        }
        if (!IsApi() && method_exists($this, "pageRedirecting")) {
            $this->pageRedirecting($url);
        }

        // Close connection
        CloseConnections();

        // Return for API
        if (IsApi()) {
            $res = $url === true;
            if (!$res) { // Show error
                WriteJson(array_merge(["success" => false], $this->getMessages()));
            }
            return;
        } else { // Check if response is JSON
            if (StartsString("application/json", $Response->getHeaderLine("Content-type")) && $Response->getBody()->getSize()) { // With JSON response
                $this->clearMessages();
                return;
            }
        }

        // Go to URL if specified
        if ($url != "") {
            if (!Config("DEBUG") && ob_get_length()) {
                ob_end_clean();
            }
            SaveDebugMessage();
            Redirect(GetUrl($url));
        }
        return; // Return to controller
    }

    // Get records from recordset
    protected function getRecordsFromRecordset($rs, $current = false)
    {
        $rows = [];
        if (is_object($rs)) { // Recordset
            while ($rs && !$rs->EOF) {
                $this->loadRowValues($rs); // Set up DbValue/CurrentValue
                $row = $this->getRecordFromArray($rs->fields);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
                $rs->moveNext();
            }
        } elseif (is_array($rs)) {
            foreach ($rs as $ar) {
                $row = $this->getRecordFromArray($ar);
                if ($current) {
                    return $row;
                } else {
                    $rows[] = $row;
                }
            }
        }
        return $rows;
    }

    // Get record from array
    protected function getRecordFromArray($ar)
    {
        $row = [];
        if (is_array($ar)) {
            foreach ($ar as $fldname => $val) {
                if (array_key_exists($fldname, $this->Fields) && ($this->Fields[$fldname]->Visible || $this->Fields[$fldname]->IsPrimaryKey)) { // Primary key or Visible
                    $fld = &$this->Fields[$fldname];
                    if ($fld->HtmlTag == "FILE") { // Upload field
                        if (EmptyValue($val)) {
                            $row[$fldname] = null;
                        } else {
                            if ($fld->DataType == DATATYPE_BLOB) {
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . $fld->Param . "/" . rawurlencode($this->getRecordKeyValue($ar))));
                                $row[$fldname] = ["type" => ContentType($val), "url" => $url, "name" => $fld->Param . ContentExtension($val)];
                            } elseif (!$fld->UploadMultiple || !ContainsString($val, Config("MULTIPLE_UPLOAD_SEPARATOR"))) { // Single file
                                $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                    "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $val)));
                                $row[$fldname] = ["type" => MimeContentType($val), "url" => $url, "name" => $val];
                            } else { // Multiple files
                                $files = explode(Config("MULTIPLE_UPLOAD_SEPARATOR"), $val);
                                $ar = [];
                                foreach ($files as $file) {
                                    $url = FullUrl(GetApiUrl(Config("API_FILE_ACTION") .
                                        "/" . $fld->TableVar . "/" . Encrypt($fld->physicalUploadPath() . $file)));
                                    if (!EmptyValue($file)) {
                                        $ar[] = ["type" => MimeContentType($file), "url" => $url, "name" => $file];
                                    }
                                }
                                $row[$fldname] = $ar;
                            }
                        }
                    } else {
                        if ($fld->DataType == DATATYPE_MEMO && $fld->MemoMaxLength > 0) {
                            $val = TruncateMemo($val, $fld->MemoMaxLength, $fld->TruncateMemoRemoveHtml);
                        }
                        $row[$fldname] = $val;
                    }
                }
            }
        }
        return $row;
    }

    // Get record key value from array
    protected function getRecordKeyValue($ar)
    {
        $key = "";
        if (is_array($ar)) {
            $key .= @$ar['id'];
        }
        return $key;
    }

    /**
     * Hide fields for add/edit
     *
     * @return void
     */
    protected function hideFieldsForAddEdit()
    {
        if ($this->isAdd() || $this->isCopy() || $this->isGridAdd()) {
            $this->id->Visible = false;
        }
    }

    // Lookup data
    public function lookup()
    {
        global $Language, $Security;

        // Get lookup object
        $fieldName = Post("field");
        $lookup = $this->Fields[$fieldName]->Lookup;

        // Get lookup parameters
        $lookupType = Post("ajax", "unknown");
        $pageSize = -1;
        $offset = -1;
        $searchValue = "";
        if (SameText($lookupType, "modal")) {
            $searchValue = Post("sv", "");
            $pageSize = Post("recperpage", 10);
            $offset = Post("start", 0);
        } elseif (SameText($lookupType, "autosuggest")) {
            $searchValue = Param("q", "");
            $pageSize = Param("n", -1);
            $pageSize = is_numeric($pageSize) ? (int)$pageSize : -1;
            if ($pageSize <= 0) {
                $pageSize = Config("AUTO_SUGGEST_MAX_ENTRIES");
            }
            $start = Param("start", -1);
            $start = is_numeric($start) ? (int)$start : -1;
            $page = Param("page", -1);
            $page = is_numeric($page) ? (int)$page : -1;
            $offset = $start >= 0 ? $start : ($page > 0 && $pageSize > 0 ? ($page - 1) * $pageSize : 0);
        }
        $userSelect = Decrypt(Post("s", ""));
        $userFilter = Decrypt(Post("f", ""));
        $userOrderBy = Decrypt(Post("o", ""));
        $keys = Post("keys");
        $lookup->LookupType = $lookupType; // Lookup type
        if ($keys !== null) { // Selected records from modal
            if (is_array($keys)) {
                $keys = implode(Config("MULTIPLE_OPTION_SEPARATOR"), $keys);
            }
            $lookup->FilterFields = []; // Skip parent fields if any
            $lookup->FilterValues[] = $keys; // Lookup values
            $pageSize = -1; // Show all records
        } else { // Lookup values
            $lookup->FilterValues[] = Post("v0", Post("lookupValue", ""));
        }
        $cnt = is_array($lookup->FilterFields) ? count($lookup->FilterFields) : 0;
        for ($i = 1; $i <= $cnt; $i++) {
            $lookup->FilterValues[] = Post("v" . $i, "");
        }
        $lookup->SearchValue = $searchValue;
        $lookup->PageSize = $pageSize;
        $lookup->Offset = $offset;
        if ($userSelect != "") {
            $lookup->UserSelect = $userSelect;
        }
        if ($userFilter != "") {
            $lookup->UserFilter = $userFilter;
        }
        if ($userOrderBy != "") {
            $lookup->UserOrderBy = $userOrderBy;
        }
        $lookup->toJson($this); // Use settings from current page
    }

    // Class variables
    public $ListOptions; // List options
    public $ExportOptions; // Export options
    public $SearchOptions; // Search options
    public $OtherOptions; // Other options
    public $FilterOptions; // Filter options
    public $ImportOptions; // Import options
    public $ListActions; // List actions
    public $SelectedCount = 0;
    public $SelectedIndex = 0;
    public $DisplayRecords = 20;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $PageSizes = "10,20,50,-1"; // Page sizes (comma separated)
    public $DefaultSearchWhere = ""; // Default search WHERE clause
    public $SearchWhere = ""; // Search WHERE clause
    public $SearchPanelClass = "ew-search-panel collapse show"; // Search Panel class
    public $SearchRowCount = 0; // For extended search
    public $SearchColumnCount = 0; // For extended search
    public $SearchFieldsPerRow = 1; // For extended search
    public $RecordCount = 0; // Record count
    public $EditRowCount;
    public $StartRowCount = 1;
    public $RowCount = 0;
    public $Attrs = []; // Row attributes and cell attributes
    public $RowIndex = 0; // Row index
    public $KeyCount = 0; // Key count
    public $RowAction = ""; // Row action
    public $MultiColumnClass = "col-sm";
    public $MultiColumnEditClass = "w-100";
    public $DbMasterFilter = ""; // Master filter
    public $DbDetailFilter = ""; // Detail filter
    public $MasterRecordExists;
    public $MultiSelectKey;
    public $Command;
    public $RestoreSearch = false;
    public $HashValue; // Hash value
    public $DetailPages;
    public $OldRecordset;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm;
        $this->CurrentAction = Param("action"); // Set up current action

        // Get grid add count
        $gridaddcnt = Get(Config("TABLE_GRID_ADD_ROW_COUNT"), "");
        if (is_numeric($gridaddcnt) && $gridaddcnt > 0) {
            $this->GridAddRowCount = $gridaddcnt;
        }

        // Set up list options
        $this->setupListOptions();
        $this->id->setVisibility();
        $this->idnpd->setVisibility();
        $this->status->setVisibility();
        $this->tglsubmit->setVisibility();
        $this->sifatorder->setVisibility();
        $this->ukuranutama->setVisibility();
        $this->utamahargaisipcs->setVisibility();
        $this->utamahargaprimerpcs->setVisibility();
        $this->utamahargasekunderpcs->setVisibility();
        $this->utamahargalabelpcs->setVisibility();
        $this->utamahargatotalpcs->setVisibility();
        $this->utamahargaisiorder->setVisibility();
        $this->utamahargaprimerorder->setVisibility();
        $this->utamahargasekunderorder->setVisibility();
        $this->utamahargalabelorder->setVisibility();
        $this->utamahargatotalorder->setVisibility();
        $this->ukuranlain->setVisibility();
        $this->lainhargaisipcs->setVisibility();
        $this->lainhargaprimerpcs->setVisibility();
        $this->lainhargasekunderpcs->setVisibility();
        $this->lainhargalabelpcs->setVisibility();
        $this->lainhargatotalpcs->setVisibility();
        $this->lainhargaisiorder->setVisibility();
        $this->lainhargaprimerorder->setVisibility();
        $this->lainhargasekunderorder->setVisibility();
        $this->lainhargalabelorder->setVisibility();
        $this->lainhargatotalorder->setVisibility();
        $this->isibahanaktif->setVisibility();
        $this->isibahanlain->setVisibility();
        $this->isiparfum->setVisibility();
        $this->isiestetika->setVisibility();
        $this->kemasanwadah->setVisibility();
        $this->kemasantutup->setVisibility();
        $this->kemasansekunder->setVisibility();
        $this->desainlabel->setVisibility();
        $this->cetaklabel->setVisibility();
        $this->lainlain->setVisibility();
        $this->deliverypickup->setVisibility();
        $this->deliverysinglepoint->setVisibility();
        $this->deliverymultipoint->setVisibility();
        $this->deliveryjumlahpoint->setVisibility();
        $this->deliverytermslain->setVisibility();
        $this->catatankhusus->setVisibility();
        $this->dibuatdi->setVisibility();
        $this->tanggal->setVisibility();
        $this->created_by->setVisibility();
        $this->hideFieldsForAddEdit();

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Setup other options
        $this->setupOtherOptions();

        // Set up custom action (compatible with old version)
        foreach ($this->CustomActions as $name => $action) {
            $this->ListActions->add($name, $action);
        }

        // Show checkbox column if multiple action
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE && $listaction->Allow) {
                $this->ListOptions["checkbox"]->Visible = true;
                break;
            }
        }

        // Set up lookup cache

        // Search filters
        $srchAdvanced = ""; // Advanced search filter
        $srchBasic = ""; // Basic search filter
        $filter = "";

        // Get command
        $this->Command = strtolower(Get("cmd"));
        if ($this->isPageRequest()) {
            // Process list action first
            if ($this->processListAction()) { // Ajax request
                $this->terminate();
                return;
            }

            // Set up records per page
            $this->setupDisplayRecords();

            // Handle reset command
            $this->resetCmd();

            // Set up Breadcrumb
            if (!$this->isExport()) {
                $this->setupBreadcrumb();
            }

            // Hide list options
            if ($this->isExport()) {
                $this->ListOptions->hideAllOptions(["sequence"]);
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            } elseif ($this->isGridAdd() || $this->isGridEdit()) {
                $this->ListOptions->hideAllOptions();
                $this->ListOptions->UseDropDownButton = false; // Disable drop down button
                $this->ListOptions->UseButtonGroup = false; // Disable button group
            }

            // Hide options
            if ($this->isExport() || $this->CurrentAction) {
                $this->ExportOptions->hideAllOptions();
                $this->FilterOptions->hideAllOptions();
                $this->ImportOptions->hideAllOptions();
            }

            // Hide other options
            if ($this->isExport()) {
                $this->OtherOptions->hideAllOptions();
            }

            // Get default search criteria
            AddFilter($this->DefaultSearchWhere, $this->basicSearchWhere(true));

            // Get basic search values
            $this->loadBasicSearchValues();

            // Process filter list
            if ($this->processFilterList()) {
                $this->terminate();
                return;
            }

            // Restore search parms from Session if not searching / reset / export
            if (($this->isExport() || $this->Command != "search" && $this->Command != "reset" && $this->Command != "resetall") && $this->Command != "json" && $this->checkSearchParms()) {
                $this->restoreSearchParms();
            }

            // Call Recordset SearchValidated event
            $this->recordsetSearchValidated();

            // Set up sorting order
            $this->setupSortOrder();

            // Get basic search criteria
            if (!$this->hasInvalidFields()) {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Restore display records
        if ($this->Command != "json" && $this->getRecordsPerPage() != "") {
            $this->DisplayRecords = $this->getRecordsPerPage(); // Restore from Session
        } else {
            $this->DisplayRecords = 20; // Load default
            $this->setRecordsPerPage($this->DisplayRecords); // Save default to Session
        }

        // Load Sorting Order
        if ($this->Command != "json") {
            $this->loadSortOrder();
        }

        // Load search default if no existing search criteria
        if (!$this->checkSearchParms()) {
            // Load basic search from default
            $this->BasicSearch->loadDefault();
            if ($this->BasicSearch->Keyword != "") {
                $srchBasic = $this->basicSearchWhere();
            }
        }

        // Build search criteria
        AddFilter($this->SearchWhere, $srchAdvanced);
        AddFilter($this->SearchWhere, $srchBasic);

        // Call Recordset_Searching event
        $this->recordsetSearching($this->SearchWhere);

        // Save search criteria
        if ($this->Command == "search" && !$this->RestoreSearch) {
            $this->setSearchWhere($this->SearchWhere); // Save to Session
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->Command != "json") {
            $this->SearchWhere = $this->getSearchWhere();
        }

        // Build filter
        $filter = "";
        if (!$Security->canList()) {
            $filter = "(0=1)"; // Filter all records
        }
        AddFilter($filter, $this->DbDetailFilter);
        AddFilter($filter, $this->SearchWhere);

        // Set up filter
        if ($this->Command == "json") {
            $this->UseSessionForListSql = false; // Do not use session for ListSQL
            $this->CurrentFilter = $filter;
        } else {
            $this->setSessionWhere($filter);
            $this->CurrentFilter = "";
        }
        if ($this->isGridAdd()) {
            $this->CurrentFilter = "0=1";
            $this->StartRecord = 1;
            $this->DisplayRecords = $this->GridAddRowCount;
            $this->TotalRecords = $this->DisplayRecords;
            $this->StopRecord = $this->DisplayRecords;
        } else {
            $this->TotalRecords = $this->listRecordCount();
            $this->StartRecord = 1;
            if ($this->DisplayRecords <= 0 || ($this->isExport() && $this->ExportAll)) { // Display all records
                $this->DisplayRecords = $this->TotalRecords;
            }
            if (!($this->isExport() && $this->ExportAll)) { // Set up start record position
                $this->setupStartRecord();
            }
            $this->Recordset = $this->loadRecordset($this->StartRecord - 1, $this->DisplayRecords);

            // Set no record found message
            if (!$this->CurrentAction && $this->TotalRecords == 0) {
                if (!$Security->canList()) {
                    $this->setWarningMessage(DeniedMessage());
                }
                if ($this->SearchWhere == "0=101") {
                    $this->setWarningMessage($Language->phrase("EnterSearchCriteria"));
                } else {
                    $this->setWarningMessage($Language->phrase("NoRecord"));
                }
            }
        }

        // Search options
        $this->setupSearchOptions();

        // Set up search panel class
        if ($this->SearchWhere != "") {
            AppendClass($this->SearchPanelClass, "show");
        }

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset);
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows, "totalRecordCount" => $this->TotalRecords]);
            $this->terminate(true);
            return;
        }

        // Set up pager
        $this->Pager = new PrevNextPager($this->StartRecord, $this->getRecordsPerPage(), $this->TotalRecords, $this->PageSizes, $this->RecordRange, $this->AutoHidePager, $this->AutoHidePageSizeSelector);

        // Set LoginStatus / Page_Rendering / Page_Render
        if (!IsApi() && !$this->isTerminated()) {
            // Pass table and field properties to client side
            $this->toClientVar(["tableCaption"], ["caption", "Visible", "Required", "IsInvalid", "Raw"]);

            // Setup login status
            SetupLoginStatus();

            // Pass login status to client side
            SetClientVar("login", LoginStatus());

            // Global Page Rendering event (in userfn*.php)
            Page_Rendering();

            // Page Render event
            if (method_exists($this, "pageRender")) {
                $this->pageRender();
            }
        }
    }

    // Set up number of records displayed per page
    protected function setupDisplayRecords()
    {
        $wrk = Get(Config("TABLE_REC_PER_PAGE"), "");
        if ($wrk != "") {
            if (is_numeric($wrk)) {
                $this->DisplayRecords = (int)$wrk;
            } else {
                if (SameText($wrk, "all")) { // Display all records
                    $this->DisplayRecords = -1;
                } else {
                    $this->DisplayRecords = 20; // Non-numeric, load default
                }
            }
            $this->setRecordsPerPage($this->DisplayRecords); // Save to Session
            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Build filter for all keys
    protected function buildKeyFilter()
    {
        global $CurrentForm;
        $wrkFilter = "";

        // Update row index and get row key
        $rowindex = 1;
        $CurrentForm->Index = $rowindex;
        $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        while ($thisKey != "") {
            $this->setKey($thisKey);
            if ($this->OldKey != "") {
                $filter = $this->getRecordFilter();
                if ($wrkFilter != "") {
                    $wrkFilter .= " OR ";
                }
                $wrkFilter .= $filter;
            } else {
                $wrkFilter = "0=1";
                break;
            }

            // Update row index and get row key
            $rowindex++; // Next row
            $CurrentForm->Index = $rowindex;
            $thisKey = strval($CurrentForm->getValue($this->OldKeyName));
        }
        return $wrkFilter;
    }

    // Get list of filters
    public function getFilterList()
    {
        global $UserProfile;

        // Initialize
        $filterList = "";
        $savedFilterList = "";
        $filterList = Concat($filterList, $this->id->AdvancedSearch->toJson(), ","); // Field id
        $filterList = Concat($filterList, $this->idnpd->AdvancedSearch->toJson(), ","); // Field idnpd
        $filterList = Concat($filterList, $this->status->AdvancedSearch->toJson(), ","); // Field status
        $filterList = Concat($filterList, $this->tglsubmit->AdvancedSearch->toJson(), ","); // Field tglsubmit
        $filterList = Concat($filterList, $this->sifatorder->AdvancedSearch->toJson(), ","); // Field sifatorder
        $filterList = Concat($filterList, $this->ukuranutama->AdvancedSearch->toJson(), ","); // Field ukuranutama
        $filterList = Concat($filterList, $this->utamahargaisipcs->AdvancedSearch->toJson(), ","); // Field utamahargaisipcs
        $filterList = Concat($filterList, $this->utamahargaprimerpcs->AdvancedSearch->toJson(), ","); // Field utamahargaprimerpcs
        $filterList = Concat($filterList, $this->utamahargasekunderpcs->AdvancedSearch->toJson(), ","); // Field utamahargasekunderpcs
        $filterList = Concat($filterList, $this->utamahargalabelpcs->AdvancedSearch->toJson(), ","); // Field utamahargalabelpcs
        $filterList = Concat($filterList, $this->utamahargatotalpcs->AdvancedSearch->toJson(), ","); // Field utamahargatotalpcs
        $filterList = Concat($filterList, $this->utamahargaisiorder->AdvancedSearch->toJson(), ","); // Field utamahargaisiorder
        $filterList = Concat($filterList, $this->utamahargaprimerorder->AdvancedSearch->toJson(), ","); // Field utamahargaprimerorder
        $filterList = Concat($filterList, $this->utamahargasekunderorder->AdvancedSearch->toJson(), ","); // Field utamahargasekunderorder
        $filterList = Concat($filterList, $this->utamahargalabelorder->AdvancedSearch->toJson(), ","); // Field utamahargalabelorder
        $filterList = Concat($filterList, $this->utamahargatotalorder->AdvancedSearch->toJson(), ","); // Field utamahargatotalorder
        $filterList = Concat($filterList, $this->ukuranlain->AdvancedSearch->toJson(), ","); // Field ukuranlain
        $filterList = Concat($filterList, $this->lainhargaisipcs->AdvancedSearch->toJson(), ","); // Field lainhargaisipcs
        $filterList = Concat($filterList, $this->lainhargaprimerpcs->AdvancedSearch->toJson(), ","); // Field lainhargaprimerpcs
        $filterList = Concat($filterList, $this->lainhargasekunderpcs->AdvancedSearch->toJson(), ","); // Field lainhargasekunderpcs
        $filterList = Concat($filterList, $this->lainhargalabelpcs->AdvancedSearch->toJson(), ","); // Field lainhargalabelpcs
        $filterList = Concat($filterList, $this->lainhargatotalpcs->AdvancedSearch->toJson(), ","); // Field lainhargatotalpcs
        $filterList = Concat($filterList, $this->lainhargaisiorder->AdvancedSearch->toJson(), ","); // Field lainhargaisiorder
        $filterList = Concat($filterList, $this->lainhargaprimerorder->AdvancedSearch->toJson(), ","); // Field lainhargaprimerorder
        $filterList = Concat($filterList, $this->lainhargasekunderorder->AdvancedSearch->toJson(), ","); // Field lainhargasekunderorder
        $filterList = Concat($filterList, $this->lainhargalabelorder->AdvancedSearch->toJson(), ","); // Field lainhargalabelorder
        $filterList = Concat($filterList, $this->lainhargatotalorder->AdvancedSearch->toJson(), ","); // Field lainhargatotalorder
        $filterList = Concat($filterList, $this->isibahanaktif->AdvancedSearch->toJson(), ","); // Field isibahanaktif
        $filterList = Concat($filterList, $this->isibahanlain->AdvancedSearch->toJson(), ","); // Field isibahanlain
        $filterList = Concat($filterList, $this->isiparfum->AdvancedSearch->toJson(), ","); // Field isiparfum
        $filterList = Concat($filterList, $this->isiestetika->AdvancedSearch->toJson(), ","); // Field isiestetika
        $filterList = Concat($filterList, $this->kemasanwadah->AdvancedSearch->toJson(), ","); // Field kemasanwadah
        $filterList = Concat($filterList, $this->kemasantutup->AdvancedSearch->toJson(), ","); // Field kemasantutup
        $filterList = Concat($filterList, $this->kemasansekunder->AdvancedSearch->toJson(), ","); // Field kemasansekunder
        $filterList = Concat($filterList, $this->desainlabel->AdvancedSearch->toJson(), ","); // Field desainlabel
        $filterList = Concat($filterList, $this->cetaklabel->AdvancedSearch->toJson(), ","); // Field cetaklabel
        $filterList = Concat($filterList, $this->lainlain->AdvancedSearch->toJson(), ","); // Field lainlain
        $filterList = Concat($filterList, $this->deliverypickup->AdvancedSearch->toJson(), ","); // Field deliverypickup
        $filterList = Concat($filterList, $this->deliverysinglepoint->AdvancedSearch->toJson(), ","); // Field deliverysinglepoint
        $filterList = Concat($filterList, $this->deliverymultipoint->AdvancedSearch->toJson(), ","); // Field deliverymultipoint
        $filterList = Concat($filterList, $this->deliveryjumlahpoint->AdvancedSearch->toJson(), ","); // Field deliveryjumlahpoint
        $filterList = Concat($filterList, $this->deliverytermslain->AdvancedSearch->toJson(), ","); // Field deliverytermslain
        $filterList = Concat($filterList, $this->catatankhusus->AdvancedSearch->toJson(), ","); // Field catatankhusus
        $filterList = Concat($filterList, $this->dibuatdi->AdvancedSearch->toJson(), ","); // Field dibuatdi
        $filterList = Concat($filterList, $this->tanggal->AdvancedSearch->toJson(), ","); // Field tanggal
        $filterList = Concat($filterList, $this->created_by->AdvancedSearch->toJson(), ","); // Field created_by
        if ($this->BasicSearch->Keyword != "") {
            $wrk = "\"" . Config("TABLE_BASIC_SEARCH") . "\":\"" . JsEncode($this->BasicSearch->Keyword) . "\",\"" . Config("TABLE_BASIC_SEARCH_TYPE") . "\":\"" . JsEncode($this->BasicSearch->Type) . "\"";
            $filterList = Concat($filterList, $wrk, ",");
        }

        // Return filter list in JSON
        if ($filterList != "") {
            $filterList = "\"data\":{" . $filterList . "}";
        }
        if ($savedFilterList != "") {
            $filterList = Concat($filterList, "\"filters\":" . $savedFilterList, ",");
        }
        return ($filterList != "") ? "{" . $filterList . "}" : "null";
    }

    // Process filter list
    protected function processFilterList()
    {
        global $UserProfile;
        if (Post("ajax") == "savefilters") { // Save filter request (Ajax)
            $filters = Post("filters");
            $UserProfile->setSearchFilters(CurrentUserName(), "fnpd_termslistsrch", $filters);
            WriteJson([["success" => true]]); // Success
            return true;
        } elseif (Post("cmd") == "resetfilter") {
            $this->restoreFilterList();
        }
        return false;
    }

    // Restore list of filters
    protected function restoreFilterList()
    {
        // Return if not reset filter
        if (Post("cmd") !== "resetfilter") {
            return false;
        }
        $filter = json_decode(Post("filter"), true);
        $this->Command = "search";

        // Field id
        $this->id->AdvancedSearch->SearchValue = @$filter["x_id"];
        $this->id->AdvancedSearch->SearchOperator = @$filter["z_id"];
        $this->id->AdvancedSearch->SearchCondition = @$filter["v_id"];
        $this->id->AdvancedSearch->SearchValue2 = @$filter["y_id"];
        $this->id->AdvancedSearch->SearchOperator2 = @$filter["w_id"];
        $this->id->AdvancedSearch->save();

        // Field idnpd
        $this->idnpd->AdvancedSearch->SearchValue = @$filter["x_idnpd"];
        $this->idnpd->AdvancedSearch->SearchOperator = @$filter["z_idnpd"];
        $this->idnpd->AdvancedSearch->SearchCondition = @$filter["v_idnpd"];
        $this->idnpd->AdvancedSearch->SearchValue2 = @$filter["y_idnpd"];
        $this->idnpd->AdvancedSearch->SearchOperator2 = @$filter["w_idnpd"];
        $this->idnpd->AdvancedSearch->save();

        // Field status
        $this->status->AdvancedSearch->SearchValue = @$filter["x_status"];
        $this->status->AdvancedSearch->SearchOperator = @$filter["z_status"];
        $this->status->AdvancedSearch->SearchCondition = @$filter["v_status"];
        $this->status->AdvancedSearch->SearchValue2 = @$filter["y_status"];
        $this->status->AdvancedSearch->SearchOperator2 = @$filter["w_status"];
        $this->status->AdvancedSearch->save();

        // Field tglsubmit
        $this->tglsubmit->AdvancedSearch->SearchValue = @$filter["x_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchOperator = @$filter["z_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchCondition = @$filter["v_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchValue2 = @$filter["y_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->SearchOperator2 = @$filter["w_tglsubmit"];
        $this->tglsubmit->AdvancedSearch->save();

        // Field sifatorder
        $this->sifatorder->AdvancedSearch->SearchValue = @$filter["x_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchOperator = @$filter["z_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchCondition = @$filter["v_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchValue2 = @$filter["y_sifatorder"];
        $this->sifatorder->AdvancedSearch->SearchOperator2 = @$filter["w_sifatorder"];
        $this->sifatorder->AdvancedSearch->save();

        // Field ukuranutama
        $this->ukuranutama->AdvancedSearch->SearchValue = @$filter["x_ukuranutama"];
        $this->ukuranutama->AdvancedSearch->SearchOperator = @$filter["z_ukuranutama"];
        $this->ukuranutama->AdvancedSearch->SearchCondition = @$filter["v_ukuranutama"];
        $this->ukuranutama->AdvancedSearch->SearchValue2 = @$filter["y_ukuranutama"];
        $this->ukuranutama->AdvancedSearch->SearchOperator2 = @$filter["w_ukuranutama"];
        $this->ukuranutama->AdvancedSearch->save();

        // Field utamahargaisipcs
        $this->utamahargaisipcs->AdvancedSearch->SearchValue = @$filter["x_utamahargaisipcs"];
        $this->utamahargaisipcs->AdvancedSearch->SearchOperator = @$filter["z_utamahargaisipcs"];
        $this->utamahargaisipcs->AdvancedSearch->SearchCondition = @$filter["v_utamahargaisipcs"];
        $this->utamahargaisipcs->AdvancedSearch->SearchValue2 = @$filter["y_utamahargaisipcs"];
        $this->utamahargaisipcs->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargaisipcs"];
        $this->utamahargaisipcs->AdvancedSearch->save();

        // Field utamahargaprimerpcs
        $this->utamahargaprimerpcs->AdvancedSearch->SearchValue = @$filter["x_utamahargaprimerpcs"];
        $this->utamahargaprimerpcs->AdvancedSearch->SearchOperator = @$filter["z_utamahargaprimerpcs"];
        $this->utamahargaprimerpcs->AdvancedSearch->SearchCondition = @$filter["v_utamahargaprimerpcs"];
        $this->utamahargaprimerpcs->AdvancedSearch->SearchValue2 = @$filter["y_utamahargaprimerpcs"];
        $this->utamahargaprimerpcs->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargaprimerpcs"];
        $this->utamahargaprimerpcs->AdvancedSearch->save();

        // Field utamahargasekunderpcs
        $this->utamahargasekunderpcs->AdvancedSearch->SearchValue = @$filter["x_utamahargasekunderpcs"];
        $this->utamahargasekunderpcs->AdvancedSearch->SearchOperator = @$filter["z_utamahargasekunderpcs"];
        $this->utamahargasekunderpcs->AdvancedSearch->SearchCondition = @$filter["v_utamahargasekunderpcs"];
        $this->utamahargasekunderpcs->AdvancedSearch->SearchValue2 = @$filter["y_utamahargasekunderpcs"];
        $this->utamahargasekunderpcs->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargasekunderpcs"];
        $this->utamahargasekunderpcs->AdvancedSearch->save();

        // Field utamahargalabelpcs
        $this->utamahargalabelpcs->AdvancedSearch->SearchValue = @$filter["x_utamahargalabelpcs"];
        $this->utamahargalabelpcs->AdvancedSearch->SearchOperator = @$filter["z_utamahargalabelpcs"];
        $this->utamahargalabelpcs->AdvancedSearch->SearchCondition = @$filter["v_utamahargalabelpcs"];
        $this->utamahargalabelpcs->AdvancedSearch->SearchValue2 = @$filter["y_utamahargalabelpcs"];
        $this->utamahargalabelpcs->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargalabelpcs"];
        $this->utamahargalabelpcs->AdvancedSearch->save();

        // Field utamahargatotalpcs
        $this->utamahargatotalpcs->AdvancedSearch->SearchValue = @$filter["x_utamahargatotalpcs"];
        $this->utamahargatotalpcs->AdvancedSearch->SearchOperator = @$filter["z_utamahargatotalpcs"];
        $this->utamahargatotalpcs->AdvancedSearch->SearchCondition = @$filter["v_utamahargatotalpcs"];
        $this->utamahargatotalpcs->AdvancedSearch->SearchValue2 = @$filter["y_utamahargatotalpcs"];
        $this->utamahargatotalpcs->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargatotalpcs"];
        $this->utamahargatotalpcs->AdvancedSearch->save();

        // Field utamahargaisiorder
        $this->utamahargaisiorder->AdvancedSearch->SearchValue = @$filter["x_utamahargaisiorder"];
        $this->utamahargaisiorder->AdvancedSearch->SearchOperator = @$filter["z_utamahargaisiorder"];
        $this->utamahargaisiorder->AdvancedSearch->SearchCondition = @$filter["v_utamahargaisiorder"];
        $this->utamahargaisiorder->AdvancedSearch->SearchValue2 = @$filter["y_utamahargaisiorder"];
        $this->utamahargaisiorder->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargaisiorder"];
        $this->utamahargaisiorder->AdvancedSearch->save();

        // Field utamahargaprimerorder
        $this->utamahargaprimerorder->AdvancedSearch->SearchValue = @$filter["x_utamahargaprimerorder"];
        $this->utamahargaprimerorder->AdvancedSearch->SearchOperator = @$filter["z_utamahargaprimerorder"];
        $this->utamahargaprimerorder->AdvancedSearch->SearchCondition = @$filter["v_utamahargaprimerorder"];
        $this->utamahargaprimerorder->AdvancedSearch->SearchValue2 = @$filter["y_utamahargaprimerorder"];
        $this->utamahargaprimerorder->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargaprimerorder"];
        $this->utamahargaprimerorder->AdvancedSearch->save();

        // Field utamahargasekunderorder
        $this->utamahargasekunderorder->AdvancedSearch->SearchValue = @$filter["x_utamahargasekunderorder"];
        $this->utamahargasekunderorder->AdvancedSearch->SearchOperator = @$filter["z_utamahargasekunderorder"];
        $this->utamahargasekunderorder->AdvancedSearch->SearchCondition = @$filter["v_utamahargasekunderorder"];
        $this->utamahargasekunderorder->AdvancedSearch->SearchValue2 = @$filter["y_utamahargasekunderorder"];
        $this->utamahargasekunderorder->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargasekunderorder"];
        $this->utamahargasekunderorder->AdvancedSearch->save();

        // Field utamahargalabelorder
        $this->utamahargalabelorder->AdvancedSearch->SearchValue = @$filter["x_utamahargalabelorder"];
        $this->utamahargalabelorder->AdvancedSearch->SearchOperator = @$filter["z_utamahargalabelorder"];
        $this->utamahargalabelorder->AdvancedSearch->SearchCondition = @$filter["v_utamahargalabelorder"];
        $this->utamahargalabelorder->AdvancedSearch->SearchValue2 = @$filter["y_utamahargalabelorder"];
        $this->utamahargalabelorder->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargalabelorder"];
        $this->utamahargalabelorder->AdvancedSearch->save();

        // Field utamahargatotalorder
        $this->utamahargatotalorder->AdvancedSearch->SearchValue = @$filter["x_utamahargatotalorder"];
        $this->utamahargatotalorder->AdvancedSearch->SearchOperator = @$filter["z_utamahargatotalorder"];
        $this->utamahargatotalorder->AdvancedSearch->SearchCondition = @$filter["v_utamahargatotalorder"];
        $this->utamahargatotalorder->AdvancedSearch->SearchValue2 = @$filter["y_utamahargatotalorder"];
        $this->utamahargatotalorder->AdvancedSearch->SearchOperator2 = @$filter["w_utamahargatotalorder"];
        $this->utamahargatotalorder->AdvancedSearch->save();

        // Field ukuranlain
        $this->ukuranlain->AdvancedSearch->SearchValue = @$filter["x_ukuranlain"];
        $this->ukuranlain->AdvancedSearch->SearchOperator = @$filter["z_ukuranlain"];
        $this->ukuranlain->AdvancedSearch->SearchCondition = @$filter["v_ukuranlain"];
        $this->ukuranlain->AdvancedSearch->SearchValue2 = @$filter["y_ukuranlain"];
        $this->ukuranlain->AdvancedSearch->SearchOperator2 = @$filter["w_ukuranlain"];
        $this->ukuranlain->AdvancedSearch->save();

        // Field lainhargaisipcs
        $this->lainhargaisipcs->AdvancedSearch->SearchValue = @$filter["x_lainhargaisipcs"];
        $this->lainhargaisipcs->AdvancedSearch->SearchOperator = @$filter["z_lainhargaisipcs"];
        $this->lainhargaisipcs->AdvancedSearch->SearchCondition = @$filter["v_lainhargaisipcs"];
        $this->lainhargaisipcs->AdvancedSearch->SearchValue2 = @$filter["y_lainhargaisipcs"];
        $this->lainhargaisipcs->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargaisipcs"];
        $this->lainhargaisipcs->AdvancedSearch->save();

        // Field lainhargaprimerpcs
        $this->lainhargaprimerpcs->AdvancedSearch->SearchValue = @$filter["x_lainhargaprimerpcs"];
        $this->lainhargaprimerpcs->AdvancedSearch->SearchOperator = @$filter["z_lainhargaprimerpcs"];
        $this->lainhargaprimerpcs->AdvancedSearch->SearchCondition = @$filter["v_lainhargaprimerpcs"];
        $this->lainhargaprimerpcs->AdvancedSearch->SearchValue2 = @$filter["y_lainhargaprimerpcs"];
        $this->lainhargaprimerpcs->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargaprimerpcs"];
        $this->lainhargaprimerpcs->AdvancedSearch->save();

        // Field lainhargasekunderpcs
        $this->lainhargasekunderpcs->AdvancedSearch->SearchValue = @$filter["x_lainhargasekunderpcs"];
        $this->lainhargasekunderpcs->AdvancedSearch->SearchOperator = @$filter["z_lainhargasekunderpcs"];
        $this->lainhargasekunderpcs->AdvancedSearch->SearchCondition = @$filter["v_lainhargasekunderpcs"];
        $this->lainhargasekunderpcs->AdvancedSearch->SearchValue2 = @$filter["y_lainhargasekunderpcs"];
        $this->lainhargasekunderpcs->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargasekunderpcs"];
        $this->lainhargasekunderpcs->AdvancedSearch->save();

        // Field lainhargalabelpcs
        $this->lainhargalabelpcs->AdvancedSearch->SearchValue = @$filter["x_lainhargalabelpcs"];
        $this->lainhargalabelpcs->AdvancedSearch->SearchOperator = @$filter["z_lainhargalabelpcs"];
        $this->lainhargalabelpcs->AdvancedSearch->SearchCondition = @$filter["v_lainhargalabelpcs"];
        $this->lainhargalabelpcs->AdvancedSearch->SearchValue2 = @$filter["y_lainhargalabelpcs"];
        $this->lainhargalabelpcs->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargalabelpcs"];
        $this->lainhargalabelpcs->AdvancedSearch->save();

        // Field lainhargatotalpcs
        $this->lainhargatotalpcs->AdvancedSearch->SearchValue = @$filter["x_lainhargatotalpcs"];
        $this->lainhargatotalpcs->AdvancedSearch->SearchOperator = @$filter["z_lainhargatotalpcs"];
        $this->lainhargatotalpcs->AdvancedSearch->SearchCondition = @$filter["v_lainhargatotalpcs"];
        $this->lainhargatotalpcs->AdvancedSearch->SearchValue2 = @$filter["y_lainhargatotalpcs"];
        $this->lainhargatotalpcs->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargatotalpcs"];
        $this->lainhargatotalpcs->AdvancedSearch->save();

        // Field lainhargaisiorder
        $this->lainhargaisiorder->AdvancedSearch->SearchValue = @$filter["x_lainhargaisiorder"];
        $this->lainhargaisiorder->AdvancedSearch->SearchOperator = @$filter["z_lainhargaisiorder"];
        $this->lainhargaisiorder->AdvancedSearch->SearchCondition = @$filter["v_lainhargaisiorder"];
        $this->lainhargaisiorder->AdvancedSearch->SearchValue2 = @$filter["y_lainhargaisiorder"];
        $this->lainhargaisiorder->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargaisiorder"];
        $this->lainhargaisiorder->AdvancedSearch->save();

        // Field lainhargaprimerorder
        $this->lainhargaprimerorder->AdvancedSearch->SearchValue = @$filter["x_lainhargaprimerorder"];
        $this->lainhargaprimerorder->AdvancedSearch->SearchOperator = @$filter["z_lainhargaprimerorder"];
        $this->lainhargaprimerorder->AdvancedSearch->SearchCondition = @$filter["v_lainhargaprimerorder"];
        $this->lainhargaprimerorder->AdvancedSearch->SearchValue2 = @$filter["y_lainhargaprimerorder"];
        $this->lainhargaprimerorder->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargaprimerorder"];
        $this->lainhargaprimerorder->AdvancedSearch->save();

        // Field lainhargasekunderorder
        $this->lainhargasekunderorder->AdvancedSearch->SearchValue = @$filter["x_lainhargasekunderorder"];
        $this->lainhargasekunderorder->AdvancedSearch->SearchOperator = @$filter["z_lainhargasekunderorder"];
        $this->lainhargasekunderorder->AdvancedSearch->SearchCondition = @$filter["v_lainhargasekunderorder"];
        $this->lainhargasekunderorder->AdvancedSearch->SearchValue2 = @$filter["y_lainhargasekunderorder"];
        $this->lainhargasekunderorder->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargasekunderorder"];
        $this->lainhargasekunderorder->AdvancedSearch->save();

        // Field lainhargalabelorder
        $this->lainhargalabelorder->AdvancedSearch->SearchValue = @$filter["x_lainhargalabelorder"];
        $this->lainhargalabelorder->AdvancedSearch->SearchOperator = @$filter["z_lainhargalabelorder"];
        $this->lainhargalabelorder->AdvancedSearch->SearchCondition = @$filter["v_lainhargalabelorder"];
        $this->lainhargalabelorder->AdvancedSearch->SearchValue2 = @$filter["y_lainhargalabelorder"];
        $this->lainhargalabelorder->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargalabelorder"];
        $this->lainhargalabelorder->AdvancedSearch->save();

        // Field lainhargatotalorder
        $this->lainhargatotalorder->AdvancedSearch->SearchValue = @$filter["x_lainhargatotalorder"];
        $this->lainhargatotalorder->AdvancedSearch->SearchOperator = @$filter["z_lainhargatotalorder"];
        $this->lainhargatotalorder->AdvancedSearch->SearchCondition = @$filter["v_lainhargatotalorder"];
        $this->lainhargatotalorder->AdvancedSearch->SearchValue2 = @$filter["y_lainhargatotalorder"];
        $this->lainhargatotalorder->AdvancedSearch->SearchOperator2 = @$filter["w_lainhargatotalorder"];
        $this->lainhargatotalorder->AdvancedSearch->save();

        // Field isibahanaktif
        $this->isibahanaktif->AdvancedSearch->SearchValue = @$filter["x_isibahanaktif"];
        $this->isibahanaktif->AdvancedSearch->SearchOperator = @$filter["z_isibahanaktif"];
        $this->isibahanaktif->AdvancedSearch->SearchCondition = @$filter["v_isibahanaktif"];
        $this->isibahanaktif->AdvancedSearch->SearchValue2 = @$filter["y_isibahanaktif"];
        $this->isibahanaktif->AdvancedSearch->SearchOperator2 = @$filter["w_isibahanaktif"];
        $this->isibahanaktif->AdvancedSearch->save();

        // Field isibahanlain
        $this->isibahanlain->AdvancedSearch->SearchValue = @$filter["x_isibahanlain"];
        $this->isibahanlain->AdvancedSearch->SearchOperator = @$filter["z_isibahanlain"];
        $this->isibahanlain->AdvancedSearch->SearchCondition = @$filter["v_isibahanlain"];
        $this->isibahanlain->AdvancedSearch->SearchValue2 = @$filter["y_isibahanlain"];
        $this->isibahanlain->AdvancedSearch->SearchOperator2 = @$filter["w_isibahanlain"];
        $this->isibahanlain->AdvancedSearch->save();

        // Field isiparfum
        $this->isiparfum->AdvancedSearch->SearchValue = @$filter["x_isiparfum"];
        $this->isiparfum->AdvancedSearch->SearchOperator = @$filter["z_isiparfum"];
        $this->isiparfum->AdvancedSearch->SearchCondition = @$filter["v_isiparfum"];
        $this->isiparfum->AdvancedSearch->SearchValue2 = @$filter["y_isiparfum"];
        $this->isiparfum->AdvancedSearch->SearchOperator2 = @$filter["w_isiparfum"];
        $this->isiparfum->AdvancedSearch->save();

        // Field isiestetika
        $this->isiestetika->AdvancedSearch->SearchValue = @$filter["x_isiestetika"];
        $this->isiestetika->AdvancedSearch->SearchOperator = @$filter["z_isiestetika"];
        $this->isiestetika->AdvancedSearch->SearchCondition = @$filter["v_isiestetika"];
        $this->isiestetika->AdvancedSearch->SearchValue2 = @$filter["y_isiestetika"];
        $this->isiestetika->AdvancedSearch->SearchOperator2 = @$filter["w_isiestetika"];
        $this->isiestetika->AdvancedSearch->save();

        // Field kemasanwadah
        $this->kemasanwadah->AdvancedSearch->SearchValue = @$filter["x_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchOperator = @$filter["z_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchCondition = @$filter["v_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchValue2 = @$filter["y_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->SearchOperator2 = @$filter["w_kemasanwadah"];
        $this->kemasanwadah->AdvancedSearch->save();

        // Field kemasantutup
        $this->kemasantutup->AdvancedSearch->SearchValue = @$filter["x_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchOperator = @$filter["z_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchCondition = @$filter["v_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchValue2 = @$filter["y_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->SearchOperator2 = @$filter["w_kemasantutup"];
        $this->kemasantutup->AdvancedSearch->save();

        // Field kemasansekunder
        $this->kemasansekunder->AdvancedSearch->SearchValue = @$filter["x_kemasansekunder"];
        $this->kemasansekunder->AdvancedSearch->SearchOperator = @$filter["z_kemasansekunder"];
        $this->kemasansekunder->AdvancedSearch->SearchCondition = @$filter["v_kemasansekunder"];
        $this->kemasansekunder->AdvancedSearch->SearchValue2 = @$filter["y_kemasansekunder"];
        $this->kemasansekunder->AdvancedSearch->SearchOperator2 = @$filter["w_kemasansekunder"];
        $this->kemasansekunder->AdvancedSearch->save();

        // Field desainlabel
        $this->desainlabel->AdvancedSearch->SearchValue = @$filter["x_desainlabel"];
        $this->desainlabel->AdvancedSearch->SearchOperator = @$filter["z_desainlabel"];
        $this->desainlabel->AdvancedSearch->SearchCondition = @$filter["v_desainlabel"];
        $this->desainlabel->AdvancedSearch->SearchValue2 = @$filter["y_desainlabel"];
        $this->desainlabel->AdvancedSearch->SearchOperator2 = @$filter["w_desainlabel"];
        $this->desainlabel->AdvancedSearch->save();

        // Field cetaklabel
        $this->cetaklabel->AdvancedSearch->SearchValue = @$filter["x_cetaklabel"];
        $this->cetaklabel->AdvancedSearch->SearchOperator = @$filter["z_cetaklabel"];
        $this->cetaklabel->AdvancedSearch->SearchCondition = @$filter["v_cetaklabel"];
        $this->cetaklabel->AdvancedSearch->SearchValue2 = @$filter["y_cetaklabel"];
        $this->cetaklabel->AdvancedSearch->SearchOperator2 = @$filter["w_cetaklabel"];
        $this->cetaklabel->AdvancedSearch->save();

        // Field lainlain
        $this->lainlain->AdvancedSearch->SearchValue = @$filter["x_lainlain"];
        $this->lainlain->AdvancedSearch->SearchOperator = @$filter["z_lainlain"];
        $this->lainlain->AdvancedSearch->SearchCondition = @$filter["v_lainlain"];
        $this->lainlain->AdvancedSearch->SearchValue2 = @$filter["y_lainlain"];
        $this->lainlain->AdvancedSearch->SearchOperator2 = @$filter["w_lainlain"];
        $this->lainlain->AdvancedSearch->save();

        // Field deliverypickup
        $this->deliverypickup->AdvancedSearch->SearchValue = @$filter["x_deliverypickup"];
        $this->deliverypickup->AdvancedSearch->SearchOperator = @$filter["z_deliverypickup"];
        $this->deliverypickup->AdvancedSearch->SearchCondition = @$filter["v_deliverypickup"];
        $this->deliverypickup->AdvancedSearch->SearchValue2 = @$filter["y_deliverypickup"];
        $this->deliverypickup->AdvancedSearch->SearchOperator2 = @$filter["w_deliverypickup"];
        $this->deliverypickup->AdvancedSearch->save();

        // Field deliverysinglepoint
        $this->deliverysinglepoint->AdvancedSearch->SearchValue = @$filter["x_deliverysinglepoint"];
        $this->deliverysinglepoint->AdvancedSearch->SearchOperator = @$filter["z_deliverysinglepoint"];
        $this->deliverysinglepoint->AdvancedSearch->SearchCondition = @$filter["v_deliverysinglepoint"];
        $this->deliverysinglepoint->AdvancedSearch->SearchValue2 = @$filter["y_deliverysinglepoint"];
        $this->deliverysinglepoint->AdvancedSearch->SearchOperator2 = @$filter["w_deliverysinglepoint"];
        $this->deliverysinglepoint->AdvancedSearch->save();

        // Field deliverymultipoint
        $this->deliverymultipoint->AdvancedSearch->SearchValue = @$filter["x_deliverymultipoint"];
        $this->deliverymultipoint->AdvancedSearch->SearchOperator = @$filter["z_deliverymultipoint"];
        $this->deliverymultipoint->AdvancedSearch->SearchCondition = @$filter["v_deliverymultipoint"];
        $this->deliverymultipoint->AdvancedSearch->SearchValue2 = @$filter["y_deliverymultipoint"];
        $this->deliverymultipoint->AdvancedSearch->SearchOperator2 = @$filter["w_deliverymultipoint"];
        $this->deliverymultipoint->AdvancedSearch->save();

        // Field deliveryjumlahpoint
        $this->deliveryjumlahpoint->AdvancedSearch->SearchValue = @$filter["x_deliveryjumlahpoint"];
        $this->deliveryjumlahpoint->AdvancedSearch->SearchOperator = @$filter["z_deliveryjumlahpoint"];
        $this->deliveryjumlahpoint->AdvancedSearch->SearchCondition = @$filter["v_deliveryjumlahpoint"];
        $this->deliveryjumlahpoint->AdvancedSearch->SearchValue2 = @$filter["y_deliveryjumlahpoint"];
        $this->deliveryjumlahpoint->AdvancedSearch->SearchOperator2 = @$filter["w_deliveryjumlahpoint"];
        $this->deliveryjumlahpoint->AdvancedSearch->save();

        // Field deliverytermslain
        $this->deliverytermslain->AdvancedSearch->SearchValue = @$filter["x_deliverytermslain"];
        $this->deliverytermslain->AdvancedSearch->SearchOperator = @$filter["z_deliverytermslain"];
        $this->deliverytermslain->AdvancedSearch->SearchCondition = @$filter["v_deliverytermslain"];
        $this->deliverytermslain->AdvancedSearch->SearchValue2 = @$filter["y_deliverytermslain"];
        $this->deliverytermslain->AdvancedSearch->SearchOperator2 = @$filter["w_deliverytermslain"];
        $this->deliverytermslain->AdvancedSearch->save();

        // Field catatankhusus
        $this->catatankhusus->AdvancedSearch->SearchValue = @$filter["x_catatankhusus"];
        $this->catatankhusus->AdvancedSearch->SearchOperator = @$filter["z_catatankhusus"];
        $this->catatankhusus->AdvancedSearch->SearchCondition = @$filter["v_catatankhusus"];
        $this->catatankhusus->AdvancedSearch->SearchValue2 = @$filter["y_catatankhusus"];
        $this->catatankhusus->AdvancedSearch->SearchOperator2 = @$filter["w_catatankhusus"];
        $this->catatankhusus->AdvancedSearch->save();

        // Field dibuatdi
        $this->dibuatdi->AdvancedSearch->SearchValue = @$filter["x_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchOperator = @$filter["z_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchCondition = @$filter["v_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchValue2 = @$filter["y_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->SearchOperator2 = @$filter["w_dibuatdi"];
        $this->dibuatdi->AdvancedSearch->save();

        // Field tanggal
        $this->tanggal->AdvancedSearch->SearchValue = @$filter["x_tanggal"];
        $this->tanggal->AdvancedSearch->SearchOperator = @$filter["z_tanggal"];
        $this->tanggal->AdvancedSearch->SearchCondition = @$filter["v_tanggal"];
        $this->tanggal->AdvancedSearch->SearchValue2 = @$filter["y_tanggal"];
        $this->tanggal->AdvancedSearch->SearchOperator2 = @$filter["w_tanggal"];
        $this->tanggal->AdvancedSearch->save();

        // Field created_by
        $this->created_by->AdvancedSearch->SearchValue = @$filter["x_created_by"];
        $this->created_by->AdvancedSearch->SearchOperator = @$filter["z_created_by"];
        $this->created_by->AdvancedSearch->SearchCondition = @$filter["v_created_by"];
        $this->created_by->AdvancedSearch->SearchValue2 = @$filter["y_created_by"];
        $this->created_by->AdvancedSearch->SearchOperator2 = @$filter["w_created_by"];
        $this->created_by->AdvancedSearch->save();
        $this->BasicSearch->setKeyword(@$filter[Config("TABLE_BASIC_SEARCH")]);
        $this->BasicSearch->setType(@$filter[Config("TABLE_BASIC_SEARCH_TYPE")]);
    }

    // Return basic search SQL
    protected function basicSearchSql($arKeywords, $type)
    {
        $where = "";
        $this->buildBasicSearchSql($where, $this->status, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuranutama, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->ukuranlain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isibahanaktif, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isibahanlain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isiparfum, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->isiestetika, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->kemasansekunder, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->desainlabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->cetaklabel, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->lainlain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->deliverypickup, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->deliverysinglepoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->deliverymultipoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->deliveryjumlahpoint, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->deliverytermslain, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->catatankhusus, $arKeywords, $type);
        $this->buildBasicSearchSql($where, $this->dibuatdi, $arKeywords, $type);
        return $where;
    }

    // Build basic search SQL
    protected function buildBasicSearchSql(&$where, &$fld, $arKeywords, $type)
    {
        $defCond = ($type == "OR") ? "OR" : "AND";
        $arSql = []; // Array for SQL parts
        $arCond = []; // Array for search conditions
        $cnt = count($arKeywords);
        $j = 0; // Number of SQL parts
        for ($i = 0; $i < $cnt; $i++) {
            $keyword = $arKeywords[$i];
            $keyword = trim($keyword);
            if (Config("BASIC_SEARCH_IGNORE_PATTERN") != "") {
                $keyword = preg_replace(Config("BASIC_SEARCH_IGNORE_PATTERN"), "\\", $keyword);
                $ar = explode("\\", $keyword);
            } else {
                $ar = [$keyword];
            }
            foreach ($ar as $keyword) {
                if ($keyword != "") {
                    $wrk = "";
                    if ($keyword == "OR" && $type == "") {
                        if ($j > 0) {
                            $arCond[$j - 1] = "OR";
                        }
                    } elseif ($keyword == Config("NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NULL";
                    } elseif ($keyword == Config("NOT_NULL_VALUE")) {
                        $wrk = $fld->Expression . " IS NOT NULL";
                    } elseif ($fld->IsVirtual && $fld->Visible) {
                        $wrk = $fld->VirtualExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    } elseif ($fld->DataType != DATATYPE_NUMBER || is_numeric($keyword)) {
                        $wrk = $fld->BasicSearchExpression . Like(QuotedValue("%" . $keyword . "%", DATATYPE_STRING, $this->Dbid), $this->Dbid);
                    }
                    if ($wrk != "") {
                        $arSql[$j] = $wrk;
                        $arCond[$j] = $defCond;
                        $j += 1;
                    }
                }
            }
        }
        $cnt = count($arSql);
        $quoted = false;
        $sql = "";
        if ($cnt > 0) {
            for ($i = 0; $i < $cnt - 1; $i++) {
                if ($arCond[$i] == "OR") {
                    if (!$quoted) {
                        $sql .= "(";
                    }
                    $quoted = true;
                }
                $sql .= $arSql[$i];
                if ($quoted && $arCond[$i] != "OR") {
                    $sql .= ")";
                    $quoted = false;
                }
                $sql .= " " . $arCond[$i] . " ";
            }
            $sql .= $arSql[$cnt - 1];
            if ($quoted) {
                $sql .= ")";
            }
        }
        if ($sql != "") {
            if ($where != "") {
                $where .= " OR ";
            }
            $where .= "(" . $sql . ")";
        }
    }

    // Return basic search WHERE clause based on search keyword and type
    protected function basicSearchWhere($default = false)
    {
        global $Security;
        $searchStr = "";
        if (!$Security->canSearch()) {
            return "";
        }
        $searchKeyword = ($default) ? $this->BasicSearch->KeywordDefault : $this->BasicSearch->Keyword;
        $searchType = ($default) ? $this->BasicSearch->TypeDefault : $this->BasicSearch->Type;

        // Get search SQL
        if ($searchKeyword != "") {
            $ar = $this->BasicSearch->keywordList($default);
            // Search keyword in any fields
            if (($searchType == "OR" || $searchType == "AND") && $this->BasicSearch->BasicSearchAnyFields) {
                foreach ($ar as $keyword) {
                    if ($keyword != "") {
                        if ($searchStr != "") {
                            $searchStr .= " " . $searchType . " ";
                        }
                        $searchStr .= "(" . $this->basicSearchSql([$keyword], $searchType) . ")";
                    }
                }
            } else {
                $searchStr = $this->basicSearchSql($ar, $searchType);
            }
            if (!$default && in_array($this->Command, ["", "reset", "resetall"])) {
                $this->Command = "search";
            }
        }
        if (!$default && $this->Command == "search") {
            $this->BasicSearch->setKeyword($searchKeyword);
            $this->BasicSearch->setType($searchType);
        }
        return $searchStr;
    }

    // Check if search parm exists
    protected function checkSearchParms()
    {
        // Check basic search
        if ($this->BasicSearch->issetSession()) {
            return true;
        }
        return false;
    }

    // Clear all search parameters
    protected function resetSearchParms()
    {
        // Clear search WHERE clause
        $this->SearchWhere = "";
        $this->setSearchWhere($this->SearchWhere);

        // Clear basic search parameters
        $this->resetBasicSearchParms();
    }

    // Load advanced search default values
    protected function loadAdvancedSearchDefault()
    {
        return false;
    }

    // Clear all basic search parameters
    protected function resetBasicSearchParms()
    {
        $this->BasicSearch->unsetSession();
    }

    // Restore all search parameters
    protected function restoreSearchParms()
    {
        $this->RestoreSearch = true;

        // Restore basic search values
        $this->BasicSearch->load();
    }

    // Set up sort parameters
    protected function setupSortOrder()
    {
        // Check for Ctrl pressed
        $ctrl = Get("ctrl") !== null;

        // Check for "order" parameter
        if (Get("order") !== null) {
            $this->CurrentOrder = Get("order");
            $this->CurrentOrderType = Get("ordertype", "");
            $this->updateSort($this->id, $ctrl); // id
            $this->updateSort($this->idnpd, $ctrl); // idnpd
            $this->updateSort($this->status, $ctrl); // status
            $this->updateSort($this->tglsubmit, $ctrl); // tglsubmit
            $this->updateSort($this->sifatorder, $ctrl); // sifatorder
            $this->updateSort($this->ukuranutama, $ctrl); // ukuranutama
            $this->updateSort($this->utamahargaisipcs, $ctrl); // utamahargaisipcs
            $this->updateSort($this->utamahargaprimerpcs, $ctrl); // utamahargaprimerpcs
            $this->updateSort($this->utamahargasekunderpcs, $ctrl); // utamahargasekunderpcs
            $this->updateSort($this->utamahargalabelpcs, $ctrl); // utamahargalabelpcs
            $this->updateSort($this->utamahargatotalpcs, $ctrl); // utamahargatotalpcs
            $this->updateSort($this->utamahargaisiorder, $ctrl); // utamahargaisiorder
            $this->updateSort($this->utamahargaprimerorder, $ctrl); // utamahargaprimerorder
            $this->updateSort($this->utamahargasekunderorder, $ctrl); // utamahargasekunderorder
            $this->updateSort($this->utamahargalabelorder, $ctrl); // utamahargalabelorder
            $this->updateSort($this->utamahargatotalorder, $ctrl); // utamahargatotalorder
            $this->updateSort($this->ukuranlain, $ctrl); // ukuranlain
            $this->updateSort($this->lainhargaisipcs, $ctrl); // lainhargaisipcs
            $this->updateSort($this->lainhargaprimerpcs, $ctrl); // lainhargaprimerpcs
            $this->updateSort($this->lainhargasekunderpcs, $ctrl); // lainhargasekunderpcs
            $this->updateSort($this->lainhargalabelpcs, $ctrl); // lainhargalabelpcs
            $this->updateSort($this->lainhargatotalpcs, $ctrl); // lainhargatotalpcs
            $this->updateSort($this->lainhargaisiorder, $ctrl); // lainhargaisiorder
            $this->updateSort($this->lainhargaprimerorder, $ctrl); // lainhargaprimerorder
            $this->updateSort($this->lainhargasekunderorder, $ctrl); // lainhargasekunderorder
            $this->updateSort($this->lainhargalabelorder, $ctrl); // lainhargalabelorder
            $this->updateSort($this->lainhargatotalorder, $ctrl); // lainhargatotalorder
            $this->updateSort($this->isibahanaktif, $ctrl); // isibahanaktif
            $this->updateSort($this->isibahanlain, $ctrl); // isibahanlain
            $this->updateSort($this->isiparfum, $ctrl); // isiparfum
            $this->updateSort($this->isiestetika, $ctrl); // isiestetika
            $this->updateSort($this->kemasanwadah, $ctrl); // kemasanwadah
            $this->updateSort($this->kemasantutup, $ctrl); // kemasantutup
            $this->updateSort($this->kemasansekunder, $ctrl); // kemasansekunder
            $this->updateSort($this->desainlabel, $ctrl); // desainlabel
            $this->updateSort($this->cetaklabel, $ctrl); // cetaklabel
            $this->updateSort($this->lainlain, $ctrl); // lainlain
            $this->updateSort($this->deliverypickup, $ctrl); // deliverypickup
            $this->updateSort($this->deliverysinglepoint, $ctrl); // deliverysinglepoint
            $this->updateSort($this->deliverymultipoint, $ctrl); // deliverymultipoint
            $this->updateSort($this->deliveryjumlahpoint, $ctrl); // deliveryjumlahpoint
            $this->updateSort($this->deliverytermslain, $ctrl); // deliverytermslain
            $this->updateSort($this->catatankhusus, $ctrl); // catatankhusus
            $this->updateSort($this->dibuatdi, $ctrl); // dibuatdi
            $this->updateSort($this->tanggal, $ctrl); // tanggal
            $this->updateSort($this->created_by, $ctrl); // created_by
            $this->setStartRecordNumber(1); // Reset start position
        }
    }

    // Load sort order parameters
    protected function loadSortOrder()
    {
        $orderBy = $this->getSessionOrderBy(); // Get ORDER BY from Session
        if ($orderBy == "") {
            $this->DefaultSort = "";
            if ($this->getSqlOrderBy() != "") {
                $useDefaultSort = true;
                if ($useDefaultSort) {
                    $orderBy = $this->getSqlOrderBy();
                    $this->setSessionOrderBy($orderBy);
                } else {
                    $this->setSessionOrderBy("");
                }
            }
        }
    }

    // Reset command
    // - cmd=reset (Reset search parameters)
    // - cmd=resetall (Reset search and master/detail parameters)
    // - cmd=resetsort (Reset sort parameters)
    protected function resetCmd()
    {
        // Check if reset command
        if (StartsString("reset", $this->Command)) {
            // Reset search criteria
            if ($this->Command == "reset" || $this->Command == "resetall") {
                $this->resetSearchParms();
            }

            // Reset (clear) sorting order
            if ($this->Command == "resetsort") {
                $orderBy = "";
                $this->setSessionOrderBy($orderBy);
                $this->id->setSort("");
                $this->idnpd->setSort("");
                $this->status->setSort("");
                $this->tglsubmit->setSort("");
                $this->sifatorder->setSort("");
                $this->ukuranutama->setSort("");
                $this->utamahargaisipcs->setSort("");
                $this->utamahargaprimerpcs->setSort("");
                $this->utamahargasekunderpcs->setSort("");
                $this->utamahargalabelpcs->setSort("");
                $this->utamahargatotalpcs->setSort("");
                $this->utamahargaisiorder->setSort("");
                $this->utamahargaprimerorder->setSort("");
                $this->utamahargasekunderorder->setSort("");
                $this->utamahargalabelorder->setSort("");
                $this->utamahargatotalorder->setSort("");
                $this->ukuranlain->setSort("");
                $this->lainhargaisipcs->setSort("");
                $this->lainhargaprimerpcs->setSort("");
                $this->lainhargasekunderpcs->setSort("");
                $this->lainhargalabelpcs->setSort("");
                $this->lainhargatotalpcs->setSort("");
                $this->lainhargaisiorder->setSort("");
                $this->lainhargaprimerorder->setSort("");
                $this->lainhargasekunderorder->setSort("");
                $this->lainhargalabelorder->setSort("");
                $this->lainhargatotalorder->setSort("");
                $this->isibahanaktif->setSort("");
                $this->isibahanlain->setSort("");
                $this->isiparfum->setSort("");
                $this->isiestetika->setSort("");
                $this->kemasanwadah->setSort("");
                $this->kemasantutup->setSort("");
                $this->kemasansekunder->setSort("");
                $this->desainlabel->setSort("");
                $this->cetaklabel->setSort("");
                $this->lainlain->setSort("");
                $this->deliverypickup->setSort("");
                $this->deliverysinglepoint->setSort("");
                $this->deliverymultipoint->setSort("");
                $this->deliveryjumlahpoint->setSort("");
                $this->deliverytermslain->setSort("");
                $this->catatankhusus->setSort("");
                $this->dibuatdi->setSort("");
                $this->tanggal->setSort("");
                $this->created_by->setSort("");
            }

            // Reset start position
            $this->StartRecord = 1;
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Set up list options
    protected function setupListOptions()
    {
        global $Security, $Language;

        // Add group option item
        $item = &$this->ListOptions->add($this->ListOptions->GroupOptionName);
        $item->Body = "";
        $item->OnLeft = false;
        $item->Visible = false;

        // "view"
        $item = &$this->ListOptions->add("view");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canView();
        $item->OnLeft = false;

        // "edit"
        $item = &$this->ListOptions->add("edit");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canEdit();
        $item->OnLeft = false;

        // "copy"
        $item = &$this->ListOptions->add("copy");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canAdd();
        $item->OnLeft = false;

        // "delete"
        $item = &$this->ListOptions->add("delete");
        $item->CssClass = "text-nowrap";
        $item->Visible = $Security->canDelete();
        $item->OnLeft = false;

        // List actions
        $item = &$this->ListOptions->add("listactions");
        $item->CssClass = "text-nowrap";
        $item->OnLeft = false;
        $item->Visible = false;
        $item->ShowInButtonGroup = false;
        $item->ShowInDropDown = false;

        // "checkbox"
        $item = &$this->ListOptions->add("checkbox");
        $item->Visible = false;
        $item->OnLeft = false;
        $item->Header = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" name=\"key\" id=\"key\" class=\"custom-control-input\" onclick=\"ew.selectAllKey(this);\"><label class=\"custom-control-label\" for=\"key\"></label></div>";
        $item->ShowInDropDown = false;
        $item->ShowInButtonGroup = false;

        // Drop down button for ListOptions
        $this->ListOptions->UseDropDownButton = false;
        $this->ListOptions->DropDownButtonPhrase = $Language->phrase("ButtonListOptions");
        $this->ListOptions->UseButtonGroup = false;
        if ($this->ListOptions->UseButtonGroup && IsMobile()) {
            $this->ListOptions->UseDropDownButton = true;
        }

        //$this->ListOptions->ButtonClass = ""; // Class for button group

        // Call ListOptions_Load event
        $this->listOptionsLoad();
        $this->setupListOptionsExt();
        $item = $this->ListOptions[$this->ListOptions->GroupOptionName];
        $item->Visible = $this->ListOptions->groupOptionVisible();
    }

    // Render list options
    public function renderListOptions()
    {
        global $Security, $Language, $CurrentForm;
        $this->ListOptions->loadDefault();

        // Call ListOptions_Rendering event
        $this->listOptionsRendering();
        $pageUrl = $this->pageUrl();
        if ($this->CurrentMode == "view") {
            // "view"
            $opt = $this->ListOptions["view"];
            $viewcaption = HtmlTitle($Language->phrase("ViewLink"));
            if ($Security->canView()) {
                $opt->Body = "<a class=\"ew-row-link ew-view\" title=\"" . $viewcaption . "\" data-caption=\"" . $viewcaption . "\" href=\"" . HtmlEncode(GetUrl($this->ViewUrl)) . "\">" . $Language->phrase("ViewLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "edit"
            $opt = $this->ListOptions["edit"];
            $editcaption = HtmlTitle($Language->phrase("EditLink"));
            if ($Security->canEdit()) {
                $opt->Body = "<a class=\"ew-row-link ew-edit\" title=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("EditLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("EditLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "copy"
            $opt = $this->ListOptions["copy"];
            $copycaption = HtmlTitle($Language->phrase("CopyLink"));
            if ($Security->canAdd()) {
                $opt->Body = "<a class=\"ew-row-link ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("CopyLink") . "</a>";
            } else {
                $opt->Body = "";
            }

            // "delete"
            $opt = $this->ListOptions["delete"];
            if ($Security->canDelete()) {
            $opt->Body = "<a class=\"ew-row-link ew-delete\"" . "" . " title=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("DeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("DeleteLink") . "</a>";
            } else {
                $opt->Body = "";
            }
        } // End View mode

        // Set up list action buttons
        $opt = $this->ListOptions["listactions"];
        if ($opt && !$this->isExport() && !$this->CurrentAction) {
            $body = "";
            $links = [];
            foreach ($this->ListActions->Items as $listaction) {
                if ($listaction->Select == ACTION_SINGLE && $listaction->Allow) {
                    $action = $listaction->Action;
                    $caption = $listaction->Caption;
                    $icon = ($listaction->Icon != "") ? "<i class=\"" . HtmlEncode(str_replace(" ew-icon", "", $listaction->Icon)) . "\" data-caption=\"" . HtmlTitle($caption) . "\"></i> " : "";
                    $links[] = "<li><a class=\"dropdown-item ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a></li>";
                    if (count($links) == 1) { // Single button
                        $body = "<a class=\"ew-action ew-list-action\" data-action=\"" . HtmlEncode($action) . "\" title=\"" . HtmlTitle($caption) . "\" data-caption=\"" . HtmlTitle($caption) . "\" href=\"#\" onclick=\"return ew.submitAction(event,jQuery.extend({key:" . $this->keyToJson(true) . "}," . $listaction->toJson(true) . "));\">" . $icon . $listaction->Caption . "</a>";
                    }
                }
            }
            if (count($links) > 1) { // More than one buttons, use dropdown
                $body = "<button class=\"dropdown-toggle btn btn-default ew-actions\" title=\"" . HtmlTitle($Language->phrase("ListActionButton")) . "\" data-toggle=\"dropdown\">" . $Language->phrase("ListActionButton") . "</button>";
                $content = "";
                foreach ($links as $link) {
                    $content .= "<li>" . $link . "</li>";
                }
                $body .= "<ul class=\"dropdown-menu" . ($opt->OnLeft ? "" : " dropdown-menu-right") . "\">" . $content . "</ul>";
                $body = "<div class=\"btn-group btn-group-sm\">" . $body . "</div>";
            }
            if (count($links) > 0) {
                $opt->Body = $body;
                $opt->Visible = true;
            }
        }

        // "checkbox"
        $opt = $this->ListOptions["checkbox"];
        $opt->Body = "<div class=\"custom-control custom-checkbox d-inline-block\"><input type=\"checkbox\" id=\"key_m_" . $this->RowCount . "\" name=\"key_m[]\" class=\"custom-control-input ew-multi-select\" value=\"" . HtmlEncode($this->id->CurrentValue) . "\" onclick=\"ew.clickMultiCheckbox(event);\"><label class=\"custom-control-label\" for=\"key_m_" . $this->RowCount . "\"></label></div>";
        $this->renderListOptionsExt();

        // Call ListOptions_Rendered event
        $this->listOptionsRendered();
    }

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["addedit"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("AddLink"));
        $item->Body = "<a class=\"ew-add-edit ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("AddLink") . "</a>";
        $item->Visible = $this->AddUrl != "" && $Security->canAdd();
        $option = $options["action"];

        // Set up options default
        foreach ($options as $option) {
            $option->UseDropDownButton = false;
            $option->UseButtonGroup = true;
            //$option->ButtonClass = ""; // Class for button group
            $item = &$option->add($option->GroupOptionName);
            $item->Body = "";
            $item->Visible = false;
        }
        $options["addedit"]->DropDownButtonPhrase = $Language->phrase("ButtonAddEdit");
        $options["detail"]->DropDownButtonPhrase = $Language->phrase("ButtonDetails");
        $options["action"]->DropDownButtonPhrase = $Language->phrase("ButtonActions");

        // Filter button
        $item = &$this->FilterOptions->add("savecurrentfilter");
        $item->Body = "<a class=\"ew-save-filter\" data-form=\"fnpd_termslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("SaveCurrentFilter") . "</a>";
        $item->Visible = true;
        $item = &$this->FilterOptions->add("deletefilter");
        $item->Body = "<a class=\"ew-delete-filter\" data-form=\"fnpd_termslistsrch\" href=\"#\" onclick=\"return false;\">" . $Language->phrase("DeleteFilter") . "</a>";
        $item->Visible = true;
        $this->FilterOptions->UseDropDownButton = true;
        $this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton;
        $this->FilterOptions->DropDownButtonPhrase = $Language->phrase("Filters");

        // Add group option item
        $item = &$this->FilterOptions->add($this->FilterOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
    }

    // Render other options
    public function renderOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];
        // Set up list action buttons
        foreach ($this->ListActions->Items as $listaction) {
            if ($listaction->Select == ACTION_MULTIPLE) {
                $item = &$option->add("custom_" . $listaction->Action);
                $caption = $listaction->Caption;
                $icon = ($listaction->Icon != "") ? '<i class="' . HtmlEncode($listaction->Icon) . '" data-caption="' . HtmlEncode($caption) . '"></i>' . $caption : $caption;
                $item->Body = '<a class="ew-action ew-list-action" title="' . HtmlEncode($caption) . '" data-caption="' . HtmlEncode($caption) . '" href="#" onclick="return ew.submitAction(event,jQuery.extend({f:document.fnpd_termslist},' . $listaction->toJson(true) . '));">' . $icon . '</a>';
                $item->Visible = $listaction->Allow;
            }
        }

        // Hide grid edit and other options
        if ($this->TotalRecords <= 0) {
            $option = $options["addedit"];
            $item = $option["gridedit"];
            if ($item) {
                $item->Visible = false;
            }
            $option = $options["action"];
            $option->hideAllOptions();
        }
    }

    // Process list action
    protected function processListAction()
    {
        global $Language, $Security;
        $userlist = "";
        $user = "";
        $filter = $this->getFilterFromRecordKeys();
        $userAction = Post("useraction", "");
        if ($filter != "" && $userAction != "") {
            // Check permission first
            $actionCaption = $userAction;
            if (array_key_exists($userAction, $this->ListActions->Items)) {
                $actionCaption = $this->ListActions[$userAction]->Caption;
                if (!$this->ListActions[$userAction]->Allow) {
                    $errmsg = str_replace('%s', $actionCaption, $Language->phrase("CustomActionNotAllowed"));
                    if (Post("ajax") == $userAction) { // Ajax
                        echo "<p class=\"text-danger\">" . $errmsg . "</p>";
                        return true;
                    } else {
                        $this->setFailureMessage($errmsg);
                        return false;
                    }
                }
            }
            $this->CurrentFilter = $filter;
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $rs = LoadRecordset($sql, $conn, \PDO::FETCH_ASSOC);
            $this->CurrentAction = $userAction;

            // Call row action event
            if ($rs) {
                $conn->beginTransaction();
                $this->SelectedCount = $rs->recordCount();
                $this->SelectedIndex = 0;
                while (!$rs->EOF) {
                    $this->SelectedIndex++;
                    $row = $rs->fields;
                    $processed = $this->rowCustomAction($userAction, $row);
                    if (!$processed) {
                        break;
                    }
                    $rs->moveNext();
                }
                if ($processed) {
                    $conn->commit(); // Commit the changes
                    if ($this->getSuccessMessage() == "" && !ob_get_length()) { // No output
                        $this->setSuccessMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionCompleted"))); // Set up success message
                    }
                } else {
                    $conn->rollback(); // Rollback changes

                    // Set up error message
                    if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                        // Use the message, do nothing
                    } elseif ($this->CancelMessage != "") {
                        $this->setFailureMessage($this->CancelMessage);
                        $this->CancelMessage = "";
                    } else {
                        $this->setFailureMessage(str_replace('%s', $actionCaption, $Language->phrase("CustomActionFailed")));
                    }
                }
            }
            if ($rs) {
                $rs->close();
            }
            $this->CurrentAction = ""; // Clear action
            if (Post("ajax") == $userAction) { // Ajax
                if ($this->getSuccessMessage() != "") {
                    echo "<p class=\"text-success\">" . $this->getSuccessMessage() . "</p>";
                    $this->clearSuccessMessage(); // Clear message
                }
                if ($this->getFailureMessage() != "") {
                    echo "<p class=\"text-danger\">" . $this->getFailureMessage() . "</p>";
                    $this->clearFailureMessage(); // Clear message
                }
                return true;
            }
        }
        return false; // Not ajax request
    }

    // Set up list options (extended codes)
    protected function setupListOptionsExt()
    {
        // Hide detail items for dropdown if necessary
        $this->ListOptions->hideDetailItemsForDropDown();
    }

    // Render list options (extended codes)
    protected function renderListOptionsExt()
    {
        global $Security, $Language;
    }

    // Load basic search values
    protected function loadBasicSearchValues()
    {
        $this->BasicSearch->setKeyword(Get(Config("TABLE_BASIC_SEARCH"), ""), false);
        if ($this->BasicSearch->Keyword != "" && $this->Command == "") {
            $this->Command = "search";
        }
        $this->BasicSearch->setType(Get(Config("TABLE_BASIC_SEARCH_TYPE"), ""), false);
    }

    // Load recordset
    public function loadRecordset($offset = -1, $rowcnt = -1)
    {
        // Load List page SQL (QueryBuilder)
        $sql = $this->getListSql();

        // Load recordset
        if ($offset > -1) {
            $sql->setFirstResult($offset);
        }
        if ($rowcnt > 0) {
            $sql->setMaxResults($rowcnt);
        }
        $stmt = $sql->execute();
        $rs = new Recordset($stmt, $sql);

        // Call Recordset Selected event
        $this->recordsetSelected($rs);
        return $rs;
    }

    /**
     * Load row based on key values
     *
     * @return void
     */
    public function loadRow()
    {
        global $Security, $Language;
        $filter = $this->getRecordFilter();

        // Call Row Selecting event
        $this->rowSelecting($filter);

        // Load SQL based on filter
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $conn = $this->getConnection();
        $res = false;
        $row = $conn->fetchAssoc($sql);
        if ($row) {
            $res = true;
            $this->loadRowValues($row); // Load row values
        }
        return $res;
    }

    /**
     * Load row values from recordset or record
     *
     * @param Recordset|array $rs Record
     * @return void
     */
    public function loadRowValues($rs = null)
    {
        if (is_array($rs)) {
            $row = $rs;
        } elseif ($rs && property_exists($rs, "fields")) { // Recordset
            $row = $rs->fields;
        } else {
            $row = $this->newRow();
        }

        // Call Row Selected event
        $this->rowSelected($row);
        if (!$rs) {
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

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['status'] = null;
        $row['tglsubmit'] = null;
        $row['sifatorder'] = null;
        $row['ukuranutama'] = null;
        $row['utamahargaisipcs'] = null;
        $row['utamahargaprimerpcs'] = null;
        $row['utamahargasekunderpcs'] = null;
        $row['utamahargalabelpcs'] = null;
        $row['utamahargatotalpcs'] = null;
        $row['utamahargaisiorder'] = null;
        $row['utamahargaprimerorder'] = null;
        $row['utamahargasekunderorder'] = null;
        $row['utamahargalabelorder'] = null;
        $row['utamahargatotalorder'] = null;
        $row['ukuranlain'] = null;
        $row['lainhargaisipcs'] = null;
        $row['lainhargaprimerpcs'] = null;
        $row['lainhargasekunderpcs'] = null;
        $row['lainhargalabelpcs'] = null;
        $row['lainhargatotalpcs'] = null;
        $row['lainhargaisiorder'] = null;
        $row['lainhargaprimerorder'] = null;
        $row['lainhargasekunderorder'] = null;
        $row['lainhargalabelorder'] = null;
        $row['lainhargatotalorder'] = null;
        $row['isibahanaktif'] = null;
        $row['isibahanlain'] = null;
        $row['isiparfum'] = null;
        $row['isiestetika'] = null;
        $row['kemasanwadah'] = null;
        $row['kemasantutup'] = null;
        $row['kemasansekunder'] = null;
        $row['desainlabel'] = null;
        $row['cetaklabel'] = null;
        $row['lainlain'] = null;
        $row['deliverypickup'] = null;
        $row['deliverysinglepoint'] = null;
        $row['deliverymultipoint'] = null;
        $row['deliveryjumlahpoint'] = null;
        $row['deliverytermslain'] = null;
        $row['catatankhusus'] = null;
        $row['dibuatdi'] = null;
        $row['tanggal'] = null;
        $row['created_by'] = null;
        return $row;
    }

    // Load old record
    protected function loadOldRecord()
    {
        // Load old record
        $this->OldRecordset = null;
        $validKey = $this->OldKey != "";
        if ($validKey) {
            $this->CurrentFilter = $this->getRecordFilter();
            $sql = $this->getCurrentSql();
            $conn = $this->getConnection();
            $this->OldRecordset = LoadRecordset($sql, $conn);
        }
        $this->loadRowValues($this->OldRecordset); // Load row values
        return $validKey;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->ViewUrl = $this->getViewUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->InlineEditUrl = $this->getInlineEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->InlineCopyUrl = $this->getInlineCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

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
        if ($this->RowType == ROWTYPE_VIEW) {
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
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Set up search options
    protected function setupSearchOptions()
    {
        global $Language, $Security;
        $pageUrl = $this->pageUrl();
        $this->SearchOptions = new ListOptions("div");
        $this->SearchOptions->TagClassName = "ew-search-option";

        // Search button
        $item = &$this->SearchOptions->add("searchtoggle");
        $searchToggleClass = ($this->SearchWhere != "") ? " active" : " active";
        $item->Body = "<a class=\"btn btn-default ew-search-toggle" . $searchToggleClass . "\" href=\"#\" role=\"button\" title=\"" . $Language->phrase("SearchPanel") . "\" data-caption=\"" . $Language->phrase("SearchPanel") . "\" data-toggle=\"button\" data-form=\"fnpd_termslistsrch\" aria-pressed=\"" . ($searchToggleClass == " active" ? "true" : "false") . "\">" . $Language->phrase("SearchLink") . "</a>";
        $item->Visible = true;

        // Show all button
        $item = &$this->SearchOptions->add("showall");
        $item->Body = "<a class=\"btn btn-default ew-show-all\" title=\"" . $Language->phrase("ShowAll") . "\" data-caption=\"" . $Language->phrase("ShowAll") . "\" href=\"" . $pageUrl . "cmd=reset\">" . $Language->phrase("ShowAllBtn") . "</a>";
        $item->Visible = ($this->SearchWhere != $this->DefaultSearchWhere && $this->SearchWhere != "0=101");

        // Button group for search
        $this->SearchOptions->UseDropDownButton = false;
        $this->SearchOptions->UseButtonGroup = true;
        $this->SearchOptions->DropDownButtonPhrase = $Language->phrase("ButtonSearch");

        // Add group option item
        $item = &$this->SearchOptions->add($this->SearchOptions->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;

        // Hide search options
        if ($this->isExport() || $this->CurrentAction) {
            $this->SearchOptions->hideAllOptions();
        }
        if (!$Security->canSearch()) {
            $this->SearchOptions->hideAllOptions();
            $this->FilterOptions->hideAllOptions();
        }
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
        $Breadcrumb->add("list", $this->TableVar, $url, "", $this->TableVar, true);
    }

    // Setup lookup options
    public function setupLookupOptions($fld)
    {
        if ($fld->Lookup !== null && $fld->Lookup->Options === null) {
            // Get default connection and filter
            $conn = $this->getConnection();
            $lookupFilter = "";

            // No need to check any more
            $fld->Lookup->Options = [];

            // Set up lookup SQL and connection
            switch ($fld->FieldVar) {
                case "x_sifatorder":
                    break;
                default:
                    $lookupFilter = "";
                    break;
            }

            // Always call to Lookup->getSql so that user can setup Lookup->Options in Lookup_Selecting server event
            $sql = $fld->Lookup->getSql(false, "", $lookupFilter, $this);

            // Set up lookup cache
            if ($fld->UseLookupCache && $sql != "" && count($fld->Lookup->Options) == 0) {
                $totalCnt = $this->getRecordCount($sql, $conn);
                if ($totalCnt > $fld->LookupCacheCount) { // Total count > cache count, do not cache
                    return;
                }
                $rows = $conn->executeQuery($sql)->fetchAll(\PDO::FETCH_BOTH);
                $ar = [];
                foreach ($rows as $row) {
                    $row = $fld->Lookup->renderViewRow($row);
                    $ar[strval($row[0])] = $row;
                }
                $fld->Lookup->Options = $ar;
            }
        }
    }

    // Set up starting record parameters
    public function setupStartRecord()
    {
        if ($this->DisplayRecords == 0) {
            return;
        }
        if ($this->isPageRequest()) { // Validate request
            $startRec = Get(Config("TABLE_START_REC"));
            $pageNo = Get(Config("TABLE_PAGE_NO"));
            if ($pageNo !== null) { // Check for "pageno" parameter first
                if (is_numeric($pageNo)) {
                    $this->StartRecord = ($pageNo - 1) * $this->DisplayRecords + 1;
                    if ($this->StartRecord <= 0) {
                        $this->StartRecord = 1;
                    } elseif ($this->StartRecord >= (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1) {
                        $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1;
                    }
                    $this->setStartRecordNumber($this->StartRecord);
                }
            } elseif ($startRec !== null) { // Check for "start" parameter
                $this->StartRecord = $startRec;
                $this->setStartRecordNumber($this->StartRecord);
            }
        }
        $this->StartRecord = $this->getStartRecordNumber();

        // Check if correct start record counter
        if (!is_numeric($this->StartRecord) || $this->StartRecord == "") { // Avoid invalid start record counter
            $this->StartRecord = 1; // Reset start record counter
            $this->setStartRecordNumber($this->StartRecord);
        } elseif ($this->StartRecord > $this->TotalRecords) { // Avoid starting record > total records
            $this->StartRecord = (int)(($this->TotalRecords - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to last page first record
            $this->setStartRecordNumber($this->StartRecord);
        } elseif (($this->StartRecord - 1) % $this->DisplayRecords != 0) {
            $this->StartRecord = (int)(($this->StartRecord - 1) / $this->DisplayRecords) * $this->DisplayRecords + 1; // Point to page boundary
            $this->setStartRecordNumber($this->StartRecord);
        }
    }

    // Page Load event
    public function pageLoad()
    {
        //Log("Page Load");
    }

    // Page Unload event
    public function pageUnload()
    {
        //Log("Page Unload");
    }

    // Page Redirecting event
    public function pageRedirecting(&$url)
    {
        // Example:
        //$url = "your URL";
    }

    // Message Showing event
    // $type = ''|'success'|'failure'|'warning'
    public function messageShowing(&$msg, $type)
    {
        if ($type == 'success') {
            //$msg = "your success message";
        } elseif ($type == 'failure') {
            //$msg = "your failure message";
        } elseif ($type == 'warning') {
            //$msg = "your warning message";
        } else {
            //$msg = "your message";
        }
    }

    // Page Render event
    public function pageRender()
    {
        //Log("Page Render");
    }

    // Page Data Rendering event
    public function pageDataRendering(&$header)
    {
        // Example:
        //$header = "your header";
    }

    // Page Data Rendered event
    public function pageDataRendered(&$footer)
    {
        // Example:
        //$footer = "your footer";
    }

    // Form Custom Validate event
    public function formCustomValidate(&$customError)
    {
        // Return error message in CustomError
        return true;
    }

    // ListOptions Load event
    public function listOptionsLoad()
    {
        // Example:
        //$opt = &$this->ListOptions->Add("new");
        //$opt->Header = "xxx";
        //$opt->OnLeft = true; // Link on left
        //$opt->MoveTo(0); // Move to first column
    }

    // ListOptions Rendering event
    public function listOptionsRendering()
    {
        //Container("DetailTableGrid")->DetailAdd = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailEdit = (...condition...); // Set to true or false conditionally
        //Container("DetailTableGrid")->DetailView = (...condition...); // Set to true or false conditionally
    }

    // ListOptions Rendered event
    public function listOptionsRendered()
    {
        // Example:
        //$this->ListOptions["new"]->Body = "xxx";
    }

    // Row Custom Action event
    public function rowCustomAction($action, $row)
    {
        // Return false to abort
        return true;
    }

    // Page Exporting event
    // $this->ExportDoc = export document object
    public function pageExporting()
    {
        //$this->ExportDoc->Text = "my header"; // Export header
        //return false; // Return false to skip default export and use Row_Export event
        return true; // Return true to use default export and skip Row_Export event
    }

    // Row Export event
    // $this->ExportDoc = export document object
    public function rowExport($rs)
    {
        //$this->ExportDoc->Text .= "my content"; // Build HTML with field value: $rs["MyField"] or $this->MyField->ViewValue
    }

    // Page Exported event
    // $this->ExportDoc = export document object
    public function pageExported()
    {
        //$this->ExportDoc->Text .= "my footer"; // Export footer
        //Log($this->ExportDoc->Text);
    }

    // Page Importing event
    public function pageImporting($reader, &$options)
    {
        //var_dump($reader); // Import data reader
        //var_dump($options); // Show all options for importing
        //return false; // Return false to skip import
        return true;
    }

    // Row Import event
    public function rowImport(&$row, $cnt)
    {
        //Log($cnt); // Import record count
        //var_dump($row); // Import row
        //return false; // Return false to skip import
        return true;
    }

    // Page Imported event
    public function pageImported($reader, $results)
    {
        //var_dump($reader); // Import data reader
        //var_dump($results); // Import results
    }
}
