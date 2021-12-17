<?php

namespace PHPMaker2021\Dermateknonew;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdTermsView extends NpdTerms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "view";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_terms';

    // Page object name
    public $PageObjName = "NpdTermsView";

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

        // Table object (npd_terms)
        if (!isset($GLOBALS["npd_terms"]) || get_class($GLOBALS["npd_terms"]) == PROJECT_NAMESPACE . "npd_terms") {
            $GLOBALS["npd_terms"] = &$this;
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

            // Handle modal response
            if ($this->IsModal) { // Show as modal
                $row = ["url" => GetUrl($url), "modal" => "1"];
                $pageName = GetPageName($url);
                if ($pageName != $this->getListUrl()) { // Not List page
                    $row["caption"] = $this->getModalCaption($pageName);
                    if ($pageName == "NpdTermsView") {
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

        // Do not use lookup cache
        $this->setUseLookupCache(false);

        // Global Page Loading event (in userfn*.php)
        Page_Loading();

        // Page Load event
        if (method_exists($this, "pageLoad")) {
            $this->pageLoad();
        }

        // Set up lookup cache

        // Check modal
        if ($this->IsModal) {
            $SkipHeaderFooter = true;
        }

        // Load current record
        $loadCurrentRecord = false;
        $returnUrl = "";
        $matchRecord = false;
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
                $returnUrl = "NpdTermsList"; // Return to list
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
                        $returnUrl = "NpdTermsList"; // No matching record, return to list
                    }
                    break;
            }
        } else {
            $returnUrl = "NpdTermsList"; // Not page request, return to list
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
        $item->Visible = ($this->EditUrl != "" && $Security->canEdit());

        // Copy
        $item = &$option->add("copy");
        $copycaption = HtmlTitle($Language->phrase("ViewPageCopyLink"));
        if ($this->IsModal) {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"#\" onclick=\"return ew.modalDialogShow({lnk:this,btn:'AddBtn',url:'" . HtmlEncode(GetUrl($this->CopyUrl)) . "'});\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-copy\" title=\"" . $copycaption . "\" data-caption=\"" . $copycaption . "\" href=\"" . HtmlEncode(GetUrl($this->CopyUrl)) . "\">" . $Language->phrase("ViewPageCopyLink") . "</a>";
        }
        $item->Visible = ($this->CopyUrl != "" && $Security->canAdd());

        // Delete
        $item = &$option->add("delete");
        if ($this->IsModal) { // Handle as inline delete
            $item->Body = "<a onclick=\"return ew.confirmDelete(this);\" class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(UrlAddQuery(GetUrl($this->DeleteUrl), "action=1")) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        } else {
            $item->Body = "<a class=\"ew-action ew-delete\" title=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" data-caption=\"" . HtmlTitle($Language->phrase("ViewPageDeleteLink")) . "\" href=\"" . HtmlEncode(GetUrl($this->DeleteUrl)) . "\">" . $Language->phrase("ViewPageDeleteLink") . "</a>";
        }
        $item->Visible = ($this->DeleteUrl != "" && $Security->canDelete());

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

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdTermsList"), "", $this->TableVar, true);
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
