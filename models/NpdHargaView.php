<?php

namespace PHPMaker2021\Dermateknonew;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdHargaView extends NpdHarga
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_harga';

    // Page object name
    public $PageObjName = "NpdHargaView";

    // Rendering View
    public $RenderingView = false;

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

        // Table object (npd_harga)
        if (!isset($GLOBALS["npd_harga"]) || get_class($GLOBALS["npd_harga"]) == PROJECT_NAMESPACE . "npd_harga") {
            $GLOBALS["npd_harga"] = &$this;
        }

        // Page URL
        $pageUrl = $this->pageUrl();
        if (($keyValue = Get("id") ?? Route("id")) !== null) {
            $this->RecKey["id"] = $keyValue;
        }
        $this->ExportPrintUrl = $pageUrl . "export=print";
        $this->ExportHtmlUrl = $pageUrl . "export=html";
        $this->ExportExcelUrl = $pageUrl . "export=excel";
        $this->ExportWordUrl = $pageUrl . "export=word";
        $this->ExportXmlUrl = $pageUrl . "export=xml";
        $this->ExportCsvUrl = $pageUrl . "export=csv";
        $this->ExportPdfUrl = $pageUrl . "export=pdf";

        // Table name (for backward compatibility only)
        if (!defined(PROJECT_NAMESPACE . "TABLE_NAME")) {
            define(PROJECT_NAMESPACE . "TABLE_NAME", 'npd_harga');
        }

        // Start timer
        $DebugTimer = Container("timer");

        // Debug message
        LoadDebugMessage();

        // Open connection
        $GLOBALS["Conn"] = $GLOBALS["Conn"] ?? $this->getConnection();

        // User table object
        $UserTable = Container("usertable");

        // Export options
        $this->ExportOptions = new ListOptions("div");
        $this->ExportOptions->TagClassName = "ew-export-option";

        // Other options
        if (!$this->OtherOptions) {
            $this->OtherOptions = new ListOptionsArray();
        }
        $this->OtherOptions["action"] = new ListOptions("div");
        $this->OtherOptions["action"]->TagClassName = "ew-action-option";
        $this->OtherOptions["detail"] = new ListOptions("div");
        $this->OtherOptions["detail"]->TagClassName = "ew-detail-option";
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
                $doc = new $class(Container("npd_harga"));
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "NpdHargaView") {
                        $row["view"] = "1";
                    }
                } else { // List page should not be shown as modal => error
                    $row["error"] = $this->getFailureMessage();
                    $this->clearFailureMessage();
                }
                WriteJson($row);
            } else {
                SaveDebugMessage();
                Redirect(GetUrl($url));
            }
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
    public $ExportOptions; // Export options
    public $OtherOptions; // Other options
    public $DisplayRecords = 1;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecKey = [];
    public $IsModal = false;

    /**
     * Page run
     *
     * @return void
     */
    public function run()
    {
        global $ExportType, $CustomExportType, $ExportFileName, $UserProfile, $Language, $Security, $CurrentForm,
            $SkipHeaderFooter;

        // Is modal
        $this->IsModal = Param("modal") == "1";
        $this->CurrentAction = Param("action"); // Set up current action
        $this->id->setVisibility();
        $this->idnpd->setVisibility();
        $this->tglpengajuan->setVisibility();
        $this->idnpd_sample->setVisibility();
        $this->bentuk->setVisibility();
        $this->idviskositasbarang->setVisibility();
        $this->idaplikasibarang->setVisibility();
        $this->ukuranwadah->setVisibility();
        $this->bahanwadah->setVisibility();
        $this->warnawadah->setVisibility();
        $this->bentukwadah->setVisibility();
        $this->jenistutup->setVisibility();
        $this->bahantutup->setVisibility();
        $this->warnatutup->setVisibility();
        $this->bentuktutup->setVisibility();
        $this->segel->setVisibility();
        $this->catatanprimer->setVisibility();
        $this->packingkarton->setVisibility();
        $this->keteranganpacking->setVisibility();
        $this->beltkarton->setVisibility();
        $this->keteranganbelt->setVisibility();
        $this->bariskarton->setVisibility();
        $this->kolomkarton->setVisibility();
        $this->stackkarton->setVisibility();
        $this->isikarton->setVisibility();
        $this->jenislabel->setVisibility();
        $this->keteranganjenislabel->setVisibility();
        $this->kualitaslabel->setVisibility();
        $this->jumlahwarnalabel->setVisibility();
        $this->etiketlabel->setVisibility();
        $this->keteranganetiket->setVisibility();
        $this->kategoridelivery->setVisibility();
        $this->alamatpengiriman->setVisibility();
        $this->orderperdana->setVisibility();
        $this->orderkontrak->setVisibility();
        $this->hargapcs->setVisibility();
        $this->lampiran->setVisibility();
        $this->disetujui->setVisibility();
        $this->created_at->setVisibility();
        $this->created_by->setVisibility();
        $this->readonly->setVisibility();
        $this->hideFieldsForAddEdit();

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache
        $this->setupLookupOptions($this->idnpd);
        $this->setupLookupOptions($this->idnpd_sample);
        $this->setupLookupOptions($this->idviskositasbarang);
        $this->setupLookupOptions($this->idaplikasibarang);

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;

        // Set up master/detail parameters
        $this->setupMasterParms();
        if ($this->isPageRequest()) { // Validate request
            if (($keyValue = Get("id") ?? Route("id")) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->RecKey["id"] = $this->id->FormValue;
            } elseif (IsApi() && ($keyValue = Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->RecKey["id"] = $this->id->QueryStringValue;
            } else {
                $returnUrl = "NpdHargaList"; // Return to list
            }

            // Get action
            $this->CurrentAction = "show"; // Display
            switch ($this->CurrentAction) {
                case "show": // Get a record to display

                    // Load record based on key
                    if (IsApi()) {
                        $filter = $this->getRecordFilter();
                        $this->CurrentFilter = $filter;
                        $sql = $this->getCurrentSql();
                        $conn = $this->getConnection();
                        $this->Recordset = LoadRecordset($sql, $conn);
                        $res = $this->Recordset && !$this->Recordset->EOF;
                    } else {
                        $res = $this->loadRow();
                    }
                    if (!$res) { // Load record based on key
                        if ($this->getSuccessMessage() == "" && $this->getFailureMessage() == "") {
                            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                        }
                        $returnUrl = "NpdHargaList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "NpdHargaList"; // Not page request, return to list
        }
        if ($returnUrl != "") {
            $this->terminate($returnUrl);
            return;
        }

        // Set up Breadcrumb
        if (!$this->isExport()) {
            $this->setupBreadcrumb();
        }

        // Render row
        $this->RowType = ROWTYPE_VIEW;
        $this->resetAttributes();
        $this->renderRow();

        // Normal return
        if (IsApi()) {
            $rows = $this->getRecordsFromRecordset($this->Recordset, true); // Get current record only
            $this->Recordset->close();
            WriteJson(["success" => true, $this->TableVar => $rows]);
            $this->terminate(true);
            return;
        }

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

    // Set up other options
    protected function setupOtherOptions()
    {
        global $Language, $Security;
        $options = &$this->OtherOptions;
        $option = $options["action"];

        // Add
        $item = &$option->add("add");
        $addcaption = HtmlTitle($Language->phrase("ViewPageAddLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->AddUrl)) . "'});\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-add\" title=\"" . $addcaption . "\" data-caption=\"" . $addcaption . "\" href=\"" . HtmlEncode(GetUrl($this->AddUrl)) . "\">" . $Language->phrase("ViewPageAddLink") . "</a>";
        }
        $item->Visible = ($this->AddUrl != "" && $Security->canAdd());

        // Edit
        $item = &$option->add("edit");
        $editcaption = HtmlTitle($Language->phrase("ViewPageEditLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,url:'" . HtmlEncode(GetUrl($this->EditUrl)) . "'});\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-edit\" title=\"" . $editcaption . "\" data-caption=\"" . $editcaption . "\" href=\"" . HtmlEncode(GetUrl($this->EditUrl)) . "\">" . $Language->phrase("ViewPageEditLink") . "</a>";
        }
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit() && $this->showOptionLink("edit"));

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete() && $this->showOptionLink("delete"));

        // Set up action default
        $option = $options["action"];
        $option->DropDownButtonPhrase = $Language->phrase("ButtonActions");
        $option->UseDropDownButton = false;
        $option->UseButtonGroup = true;
        $item = &$option->add($option->GroupOptionName);
        $item->Body = "";
        $item->Visible = false;
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
        $this->tglpengajuan->setDbValue($row['tglpengajuan']);
        $this->idnpd_sample->setDbValue($row['idnpd_sample']);
        $this->bentuk->setDbValue($row['bentuk']);
        $this->idviskositasbarang->setDbValue($row['idviskositasbarang']);
        $this->idaplikasibarang->setDbValue($row['idaplikasibarang']);
        $this->ukuranwadah->setDbValue($row['ukuranwadah']);
        $this->bahanwadah->setDbValue($row['bahanwadah']);
        $this->warnawadah->setDbValue($row['warnawadah']);
        $this->bentukwadah->setDbValue($row['bentukwadah']);
        $this->jenistutup->setDbValue($row['jenistutup']);
        $this->bahantutup->setDbValue($row['bahantutup']);
        $this->warnatutup->setDbValue($row['warnatutup']);
        $this->bentuktutup->setDbValue($row['bentuktutup']);
        $this->segel->setDbValue($row['segel']);
        $this->catatanprimer->setDbValue($row['catatanprimer']);
        $this->packingkarton->setDbValue($row['packingkarton']);
        $this->keteranganpacking->setDbValue($row['keteranganpacking']);
        $this->beltkarton->setDbValue($row['beltkarton']);
        $this->keteranganbelt->setDbValue($row['keteranganbelt']);
        $this->bariskarton->setDbValue($row['bariskarton']);
        $this->kolomkarton->setDbValue($row['kolomkarton']);
        $this->stackkarton->setDbValue($row['stackkarton']);
        $this->isikarton->setDbValue($row['isikarton']);
        $this->jenislabel->setDbValue($row['jenislabel']);
        $this->keteranganjenislabel->setDbValue($row['keteranganjenislabel']);
        $this->kualitaslabel->setDbValue($row['kualitaslabel']);
        $this->jumlahwarnalabel->setDbValue($row['jumlahwarnalabel']);
        $this->etiketlabel->setDbValue($row['etiketlabel']);
        $this->keteranganetiket->setDbValue($row['keteranganetiket']);
        $this->kategoridelivery->setDbValue($row['kategoridelivery']);
        $this->alamatpengiriman->setDbValue($row['alamatpengiriman']);
        $this->orderperdana->setDbValue($row['orderperdana']);
        $this->orderkontrak->setDbValue($row['orderkontrak']);
        $this->hargapcs->setDbValue($row['hargapcs']);
        $this->lampiran->Upload->DbValue = $row['lampiran'];
        $this->lampiran->setDbValue($this->lampiran->Upload->DbValue);
        $this->disetujui->setDbValue($row['disetujui']);
        $this->created_at->setDbValue($row['created_at']);
        $this->created_by->setDbValue($row['created_by']);
        $this->readonly->setDbValue($row['readonly']);
    }

    // Return a row with default values
    protected function newRow()
    {
        $row = [];
        $row['id'] = null;
        $row['idnpd'] = null;
        $row['tglpengajuan'] = null;
        $row['idnpd_sample'] = null;
        $row['bentuk'] = null;
        $row['idviskositasbarang'] = null;
        $row['idaplikasibarang'] = null;
        $row['ukuranwadah'] = null;
        $row['bahanwadah'] = null;
        $row['warnawadah'] = null;
        $row['bentukwadah'] = null;
        $row['jenistutup'] = null;
        $row['bahantutup'] = null;
        $row['warnatutup'] = null;
        $row['bentuktutup'] = null;
        $row['segel'] = null;
        $row['catatanprimer'] = null;
        $row['packingkarton'] = null;
        $row['keteranganpacking'] = null;
        $row['beltkarton'] = null;
        $row['keteranganbelt'] = null;
        $row['bariskarton'] = null;
        $row['kolomkarton'] = null;
        $row['stackkarton'] = null;
        $row['isikarton'] = null;
        $row['jenislabel'] = null;
        $row['keteranganjenislabel'] = null;
        $row['kualitaslabel'] = null;
        $row['jumlahwarnalabel'] = null;
        $row['etiketlabel'] = null;
        $row['keteranganetiket'] = null;
        $row['kategoridelivery'] = null;
        $row['alamatpengiriman'] = null;
        $row['orderperdana'] = null;
        $row['orderkontrak'] = null;
        $row['hargapcs'] = null;
        $row['lampiran'] = null;
        $row['disetujui'] = null;
        $row['created_at'] = null;
        $row['created_by'] = null;
        $row['readonly'] = null;
        return $row;
    }

    // Render row values based on field settings
    public function renderRow()
    {
        global $Security, $Language, $CurrentLanguage;

        // Initialize URLs
        $this->AddUrl = $this->getAddUrl();
        $this->EditUrl = $this->getEditUrl();
        $this->CopyUrl = $this->getCopyUrl();
        $this->DeleteUrl = $this->getDeleteUrl();
        $this->ListUrl = $this->getListUrl();
        $this->setupOtherOptions();

        // Call Row_Rendering event
        $this->rowRendering();

        // Common render codes for all row types

        // id

        // idnpd

        // tglpengajuan

        // idnpd_sample

        // bentuk

        // idviskositasbarang

        // idaplikasibarang

        // ukuranwadah

        // bahanwadah

        // warnawadah

        // bentukwadah

        // jenistutup

        // bahantutup

        // warnatutup

        // bentuktutup

        // segel

        // catatanprimer

        // packingkarton

        // keteranganpacking

        // beltkarton

        // keteranganbelt

        // bariskarton

        // kolomkarton

        // stackkarton

        // isikarton

        // jenislabel

        // keteranganjenislabel

        // kualitaslabel

        // jumlahwarnalabel

        // etiketlabel

        // keteranganetiket

        // kategoridelivery

        // alamatpengiriman

        // orderperdana

        // orderkontrak

        // hargapcs

        // lampiran

        // disetujui

        // created_at

        // created_by

        // readonly
        if ($this->RowType == ROWTYPE_VIEW) {
            // id
            $this->id->ViewValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $curVal = trim(strval($this->idnpd->CurrentValue));
            if ($curVal != "") {
                $this->idnpd->ViewValue = $this->idnpd->lookupCacheOption($curVal);
                if ($this->idnpd->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idnpd->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd->ViewValue = $this->idnpd->displayValue($arwrk);
                    } else {
                        $this->idnpd->ViewValue = $this->idnpd->CurrentValue;
                    }
                }
            } else {
                $this->idnpd->ViewValue = null;
            }
            $this->idnpd->ViewCustomAttributes = "";

            // tglpengajuan
            $this->tglpengajuan->ViewValue = $this->tglpengajuan->CurrentValue;
            $this->tglpengajuan->ViewValue = FormatDateTime($this->tglpengajuan->ViewValue, 0);
            $this->tglpengajuan->ViewCustomAttributes = "";

            // idnpd_sample
            $curVal = trim(strval($this->idnpd_sample->CurrentValue));
            if ($curVal != "") {
                $this->idnpd_sample->ViewValue = $this->idnpd_sample->lookupCacheOption($curVal);
                if ($this->idnpd_sample->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $lookupFilter = function() {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0 AND idnpd = ".$this->idnpd->CurrentValue.")" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    $sqlWrk = $this->idnpd_sample->Lookup->getSql(false, $filterWrk, $lookupFilter, $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idnpd_sample->Lookup->renderViewRow($rswrk[0]);
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->displayValue($arwrk);
                    } else {
                        $this->idnpd_sample->ViewValue = $this->idnpd_sample->CurrentValue;
                    }
                }
            } else {
                $this->idnpd_sample->ViewValue = null;
            }
            $this->idnpd_sample->ViewCustomAttributes = "";

            // bentuk
            $this->bentuk->ViewValue = $this->bentuk->CurrentValue;
            $this->bentuk->ViewCustomAttributes = "";

            // idviskositasbarang
            $curVal = trim(strval($this->idviskositasbarang->CurrentValue));
            if ($curVal != "") {
                $this->idviskositasbarang->ViewValue = $this->idviskositasbarang->lookupCacheOption($curVal);
                if ($this->idviskositasbarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idviskositasbarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idviskositasbarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idviskositasbarang->ViewValue = $this->idviskositasbarang->displayValue($arwrk);
                    } else {
                        $this->idviskositasbarang->ViewValue = $this->idviskositasbarang->CurrentValue;
                    }
                }
            } else {
                $this->idviskositasbarang->ViewValue = null;
            }
            $this->idviskositasbarang->ViewCustomAttributes = "";

            // idaplikasibarang
            $curVal = trim(strval($this->idaplikasibarang->CurrentValue));
            if ($curVal != "") {
                $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->lookupCacheOption($curVal);
                if ($this->idaplikasibarang->ViewValue === null) { // Lookup from database
                    $filterWrk = "`id`" . SearchString("=", $curVal, DATATYPE_NUMBER, "");
                    $sqlWrk = $this->idaplikasibarang->Lookup->getSql(false, $filterWrk, '', $this, true, true);
                    $rswrk = Conn()->executeQuery($sqlWrk)->fetchAll(\PDO::FETCH_BOTH);
                    $ari = count($rswrk);
                    if ($ari > 0) { // Lookup values found
                        $arwrk = $this->idaplikasibarang->Lookup->renderViewRow($rswrk[0]);
                        $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->displayValue($arwrk);
                    } else {
                        $this->idaplikasibarang->ViewValue = $this->idaplikasibarang->CurrentValue;
                    }
                }
            } else {
                $this->idaplikasibarang->ViewValue = null;
            }
            $this->idaplikasibarang->ViewCustomAttributes = "";

            // ukuranwadah
            $this->ukuranwadah->ViewValue = $this->ukuranwadah->CurrentValue;
            $this->ukuranwadah->ViewCustomAttributes = "";

            // bahanwadah
            $this->bahanwadah->ViewValue = $this->bahanwadah->CurrentValue;
            $this->bahanwadah->ViewCustomAttributes = "";

            // warnawadah
            $this->warnawadah->ViewValue = $this->warnawadah->CurrentValue;
            $this->warnawadah->ViewCustomAttributes = "";

            // bentukwadah
            $this->bentukwadah->ViewValue = $this->bentukwadah->CurrentValue;
            $this->bentukwadah->ViewCustomAttributes = "";

            // jenistutup
            $this->jenistutup->ViewValue = $this->jenistutup->CurrentValue;
            $this->jenistutup->ViewCustomAttributes = "";

            // bahantutup
            $this->bahantutup->ViewValue = $this->bahantutup->CurrentValue;
            $this->bahantutup->ViewCustomAttributes = "";

            // warnatutup
            $this->warnatutup->ViewValue = $this->warnatutup->CurrentValue;
            $this->warnatutup->ViewCustomAttributes = "";

            // bentuktutup
            $this->bentuktutup->ViewValue = $this->bentuktutup->CurrentValue;
            $this->bentuktutup->ViewCustomAttributes = "";

            // segel
            if (strval($this->segel->CurrentValue) != "") {
                $this->segel->ViewValue = $this->segel->optionCaption($this->segel->CurrentValue);
            } else {
                $this->segel->ViewValue = null;
            }
            $this->segel->ViewCustomAttributes = "";

            // catatanprimer
            $this->catatanprimer->ViewValue = $this->catatanprimer->CurrentValue;
            $this->catatanprimer->ViewCustomAttributes = "";

            // packingkarton
            $this->packingkarton->ViewValue = $this->packingkarton->CurrentValue;
            $this->packingkarton->ViewCustomAttributes = "";

            // keteranganpacking
            $this->keteranganpacking->ViewValue = $this->keteranganpacking->CurrentValue;
            $this->keteranganpacking->ViewCustomAttributes = "";

            // beltkarton
            $this->beltkarton->ViewValue = $this->beltkarton->CurrentValue;
            $this->beltkarton->ViewCustomAttributes = "";

            // keteranganbelt
            $this->keteranganbelt->ViewValue = $this->keteranganbelt->CurrentValue;
            $this->keteranganbelt->ViewCustomAttributes = "";

            // bariskarton
            $this->bariskarton->ViewValue = $this->bariskarton->CurrentValue;
            $this->bariskarton->ViewValue = FormatNumber($this->bariskarton->ViewValue, 0, -2, -2, -2);
            $this->bariskarton->ViewCustomAttributes = "";

            // kolomkarton
            $this->kolomkarton->ViewValue = $this->kolomkarton->CurrentValue;
            $this->kolomkarton->ViewValue = FormatNumber($this->kolomkarton->ViewValue, 0, -2, -2, -2);
            $this->kolomkarton->ViewCustomAttributes = "";

            // stackkarton
            $this->stackkarton->ViewValue = $this->stackkarton->CurrentValue;
            $this->stackkarton->ViewValue = FormatNumber($this->stackkarton->ViewValue, 0, -2, -2, -2);
            $this->stackkarton->ViewCustomAttributes = "";

            // isikarton
            $this->isikarton->ViewValue = $this->isikarton->CurrentValue;
            $this->isikarton->ViewValue = FormatNumber($this->isikarton->ViewValue, 0, -2, -2, -2);
            $this->isikarton->ViewCustomAttributes = "";

            // jenislabel
            $this->jenislabel->ViewValue = $this->jenislabel->CurrentValue;
            $this->jenislabel->ViewCustomAttributes = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->ViewValue = $this->keteranganjenislabel->CurrentValue;
            $this->keteranganjenislabel->ViewCustomAttributes = "";

            // kualitaslabel
            $this->kualitaslabel->ViewValue = $this->kualitaslabel->CurrentValue;
            $this->kualitaslabel->ViewCustomAttributes = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->ViewValue = $this->jumlahwarnalabel->CurrentValue;
            $this->jumlahwarnalabel->ViewCustomAttributes = "";

            // etiketlabel
            $this->etiketlabel->ViewValue = $this->etiketlabel->CurrentValue;
            $this->etiketlabel->ViewCustomAttributes = "";

            // keteranganetiket
            $this->keteranganetiket->ViewValue = $this->keteranganetiket->CurrentValue;
            $this->keteranganetiket->ViewCustomAttributes = "";

            // kategoridelivery
            $this->kategoridelivery->ViewValue = $this->kategoridelivery->CurrentValue;
            $this->kategoridelivery->ViewCustomAttributes = "";

            // alamatpengiriman
            $this->alamatpengiriman->ViewValue = $this->alamatpengiriman->CurrentValue;
            $this->alamatpengiriman->ViewCustomAttributes = "";

            // orderperdana
            $this->orderperdana->ViewValue = $this->orderperdana->CurrentValue;
            $this->orderperdana->ViewValue = FormatNumber($this->orderperdana->ViewValue, 0, -2, -2, -2);
            $this->orderperdana->ViewCustomAttributes = "";

            // orderkontrak
            $this->orderkontrak->ViewValue = $this->orderkontrak->CurrentValue;
            $this->orderkontrak->ViewValue = FormatNumber($this->orderkontrak->ViewValue, 0, -2, -2, -2);
            $this->orderkontrak->ViewCustomAttributes = "";

            // hargapcs
            $this->hargapcs->ViewValue = $this->hargapcs->CurrentValue;
            $this->hargapcs->ViewValue = FormatCurrency($this->hargapcs->ViewValue, 2, -2, -2, -2);
            $this->hargapcs->ViewCustomAttributes = "";

            // lampiran
            if (!EmptyValue($this->lampiran->Upload->DbValue)) {
                $this->lampiran->ViewValue = $this->lampiran->Upload->DbValue;
            } else {
                $this->lampiran->ViewValue = "";
            }
            $this->lampiran->ViewCustomAttributes = "";

            // disetujui
            if (strval($this->disetujui->CurrentValue) != "") {
                $this->disetujui->ViewValue = $this->disetujui->optionCaption($this->disetujui->CurrentValue);
            } else {
                $this->disetujui->ViewValue = null;
            }
            $this->disetujui->ViewCustomAttributes = "";

            // created_at
            $this->created_at->ViewValue = $this->created_at->CurrentValue;
            $this->created_at->ViewValue = FormatDateTime($this->created_at->ViewValue, 0);
            $this->created_at->ViewCustomAttributes = "";

            // created_by
            $this->created_by->ViewValue = $this->created_by->CurrentValue;
            $this->created_by->ViewValue = FormatNumber($this->created_by->ViewValue, 0, -2, -2, -2);
            $this->created_by->ViewCustomAttributes = "";

            // readonly
            if (ConvertToBool($this->readonly->CurrentValue)) {
                $this->readonly->ViewValue = $this->readonly->tagCaption(1) != "" ? $this->readonly->tagCaption(1) : "Yes";
            } else {
                $this->readonly->ViewValue = $this->readonly->tagCaption(2) != "" ? $this->readonly->tagCaption(2) : "No";
            }
            $this->readonly->ViewCustomAttributes = "";

            // tglpengajuan
            $this->tglpengajuan->LinkCustomAttributes = "";
            $this->tglpengajuan->HrefValue = "";
            $this->tglpengajuan->TooltipValue = "";

            // idnpd_sample
            $this->idnpd_sample->LinkCustomAttributes = "";
            $this->idnpd_sample->HrefValue = "";
            $this->idnpd_sample->TooltipValue = "";

            // bentuk
            $this->bentuk->LinkCustomAttributes = "";
            $this->bentuk->HrefValue = "";
            $this->bentuk->TooltipValue = "";

            // idviskositasbarang
            $this->idviskositasbarang->LinkCustomAttributes = "";
            $this->idviskositasbarang->HrefValue = "";
            $this->idviskositasbarang->TooltipValue = "";

            // idaplikasibarang
            $this->idaplikasibarang->LinkCustomAttributes = "";
            $this->idaplikasibarang->HrefValue = "";
            $this->idaplikasibarang->TooltipValue = "";

            // ukuranwadah
            $this->ukuranwadah->LinkCustomAttributes = "";
            $this->ukuranwadah->HrefValue = "";
            $this->ukuranwadah->TooltipValue = "";

            // bahanwadah
            $this->bahanwadah->LinkCustomAttributes = "";
            $this->bahanwadah->HrefValue = "";
            $this->bahanwadah->TooltipValue = "";

            // warnawadah
            $this->warnawadah->LinkCustomAttributes = "";
            $this->warnawadah->HrefValue = "";
            $this->warnawadah->TooltipValue = "";

            // bentukwadah
            $this->bentukwadah->LinkCustomAttributes = "";
            $this->bentukwadah->HrefValue = "";
            $this->bentukwadah->TooltipValue = "";

            // jenistutup
            $this->jenistutup->LinkCustomAttributes = "";
            $this->jenistutup->HrefValue = "";
            $this->jenistutup->TooltipValue = "";

            // bahantutup
            $this->bahantutup->LinkCustomAttributes = "";
            $this->bahantutup->HrefValue = "";
            $this->bahantutup->TooltipValue = "";

            // warnatutup
            $this->warnatutup->LinkCustomAttributes = "";
            $this->warnatutup->HrefValue = "";
            $this->warnatutup->TooltipValue = "";

            // bentuktutup
            $this->bentuktutup->LinkCustomAttributes = "";
            $this->bentuktutup->HrefValue = "";
            $this->bentuktutup->TooltipValue = "";

            // segel
            $this->segel->LinkCustomAttributes = "";
            $this->segel->HrefValue = "";
            $this->segel->TooltipValue = "";

            // catatanprimer
            $this->catatanprimer->LinkCustomAttributes = "";
            $this->catatanprimer->HrefValue = "";
            $this->catatanprimer->TooltipValue = "";

            // packingkarton
            $this->packingkarton->LinkCustomAttributes = "";
            $this->packingkarton->HrefValue = "";
            $this->packingkarton->TooltipValue = "";

            // keteranganpacking
            $this->keteranganpacking->LinkCustomAttributes = "";
            $this->keteranganpacking->HrefValue = "";
            $this->keteranganpacking->TooltipValue = "";

            // beltkarton
            $this->beltkarton->LinkCustomAttributes = "";
            $this->beltkarton->HrefValue = "";
            $this->beltkarton->TooltipValue = "";

            // keteranganbelt
            $this->keteranganbelt->LinkCustomAttributes = "";
            $this->keteranganbelt->HrefValue = "";
            $this->keteranganbelt->TooltipValue = "";

            // bariskarton
            $this->bariskarton->LinkCustomAttributes = "";
            $this->bariskarton->HrefValue = "";
            $this->bariskarton->TooltipValue = "";

            // kolomkarton
            $this->kolomkarton->LinkCustomAttributes = "";
            $this->kolomkarton->HrefValue = "";
            $this->kolomkarton->TooltipValue = "";

            // stackkarton
            $this->stackkarton->LinkCustomAttributes = "";
            $this->stackkarton->HrefValue = "";
            $this->stackkarton->TooltipValue = "";

            // isikarton
            $this->isikarton->LinkCustomAttributes = "";
            $this->isikarton->HrefValue = "";
            $this->isikarton->TooltipValue = "";

            // jenislabel
            $this->jenislabel->LinkCustomAttributes = "";
            $this->jenislabel->HrefValue = "";
            $this->jenislabel->TooltipValue = "";

            // keteranganjenislabel
            $this->keteranganjenislabel->LinkCustomAttributes = "";
            $this->keteranganjenislabel->HrefValue = "";
            $this->keteranganjenislabel->TooltipValue = "";

            // kualitaslabel
            $this->kualitaslabel->LinkCustomAttributes = "";
            $this->kualitaslabel->HrefValue = "";
            $this->kualitaslabel->TooltipValue = "";

            // jumlahwarnalabel
            $this->jumlahwarnalabel->LinkCustomAttributes = "";
            $this->jumlahwarnalabel->HrefValue = "";
            $this->jumlahwarnalabel->TooltipValue = "";

            // etiketlabel
            $this->etiketlabel->LinkCustomAttributes = "";
            $this->etiketlabel->HrefValue = "";
            $this->etiketlabel->TooltipValue = "";

            // keteranganetiket
            $this->keteranganetiket->LinkCustomAttributes = "";
            $this->keteranganetiket->HrefValue = "";
            $this->keteranganetiket->TooltipValue = "";

            // kategoridelivery
            $this->kategoridelivery->LinkCustomAttributes = "";
            $this->kategoridelivery->HrefValue = "";
            $this->kategoridelivery->TooltipValue = "";

            // alamatpengiriman
            $this->alamatpengiriman->LinkCustomAttributes = "";
            $this->alamatpengiriman->HrefValue = "";
            $this->alamatpengiriman->TooltipValue = "";

            // orderperdana
            $this->orderperdana->LinkCustomAttributes = "";
            $this->orderperdana->HrefValue = "";
            $this->orderperdana->TooltipValue = "";

            // orderkontrak
            $this->orderkontrak->LinkCustomAttributes = "";
            $this->orderkontrak->HrefValue = "";
            $this->orderkontrak->TooltipValue = "";

            // hargapcs
            $this->hargapcs->LinkCustomAttributes = "";
            $this->hargapcs->HrefValue = "";
            $this->hargapcs->TooltipValue = "";

            // lampiran
            $this->lampiran->LinkCustomAttributes = "";
            $this->lampiran->HrefValue = "";
            $this->lampiran->ExportHrefValue = $this->lampiran->UploadPath . $this->lampiran->Upload->DbValue;
            $this->lampiran->TooltipValue = "";

            // disetujui
            $this->disetujui->LinkCustomAttributes = "";
            $this->disetujui->HrefValue = "";
            $this->disetujui->TooltipValue = "";
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Show link optionally based on User ID
    protected function showOptionLink($id = "")
    {
        global $Security;
        if ($Security->isLoggedIn() && !$Security->isAdmin() && !$this->userIDAllow($id)) {
            return $Security->isValidUserID($this->created_by->CurrentValue);
        }
        return true;
    }

    // Set up master/detail based on QueryString
    protected function setupMasterParms()
    {
        $validMaster = false;
        // Get the keys for master table
        if (($master = Get(Config("TABLE_SHOW_MASTER"), Get(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                $validMaster = true;
                $this->DbMasterFilter = "";
                $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Get("fk_id", Get("idnpd"))) !== null) {
                    $masterTbl->id->setQueryStringValue($parm);
                    $this->idnpd->setQueryStringValue($masterTbl->id->QueryStringValue);
                    $this->idnpd->setSessionValue($this->idnpd->QueryStringValue);
                    if (!is_numeric($masterTbl->id->QueryStringValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        } elseif (($master = Post(Config("TABLE_SHOW_MASTER"), Post(Config("TABLE_MASTER")))) !== null) {
            $masterTblVar = $master;
            if ($masterTblVar == "") {
                    $validMaster = true;
                    $this->DbMasterFilter = "";
                    $this->DbDetailFilter = "";
            }
            if ($masterTblVar == "npd") {
                $validMaster = true;
                $masterTbl = Container("npd");
                if (($parm = Post("fk_id", Post("idnpd"))) !== null) {
                    $masterTbl->id->setFormValue($parm);
                    $this->idnpd->setFormValue($masterTbl->id->FormValue);
                    $this->idnpd->setSessionValue($this->idnpd->FormValue);
                    if (!is_numeric($masterTbl->id->FormValue)) {
                        $validMaster = false;
                    }
                } else {
                    $validMaster = false;
                }
            }
        }
        if ($validMaster) {
            // Save current master table
            $this->setCurrentMasterTable($masterTblVar);
            $this->setSessionWhere($this->getDetailFilter());

            // Reset start record counter (new master key)
            if (!$this->isAddOrEdit()) {
                $this->StartRecord = 1;
                $this->setStartRecordNumber($this->StartRecord);
            }

            // Clear previous master key from Session
            if ($masterTblVar != "npd") {
                if ($this->idnpd->CurrentValue == "") {
                    $this->idnpd->setSessionValue("");
                }
            }
        }
        $this->DbMasterFilter = $this->getMasterFilter(); // Get master filter
        $this->DbDetailFilter = $this->getDetailFilter(); // Get detail filter
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdHargaList"), "", $this->TableVar, true);
        $pageId = "view";
        $Breadcrumb->add("view", $pageId, $url);
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
                case "x_idnpd":
                    break;
                case "x_idnpd_sample":
                    $lookupFilter = function () {
                        return CurrentPageID() == "add" ? "id IN (SELECT idnpd_sample FROM npd_confirm WHERE readonly=0 AND idnpd = ".$this->idnpd->CurrentValue.")" : "";
                    };
                    $lookupFilter = $lookupFilter->bindTo($this);
                    break;
                case "x_idviskositasbarang":
                    break;
                case "x_idaplikasibarang":
                    break;
                case "x_segel":
                    break;
                case "x_disetujui":
                    break;
                case "x_readonly":
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
        $this->OtherOptions["action"]->Items["add"]->Visible = false;
        if ($this->readonly->CurrentValue) {
        	$this->OtherOptions["action"]->Items["edit"]->Visible = false;
        	$this->OtherOptions["action"]->Items["delete"]->Visible = false;
        }
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
}
