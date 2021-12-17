<?php

namespace PHPMaker2021\Dermateknonew;

use Doctrine\DBAL\ParameterType;

/**
 * Page class
 */
class NpdTermsEdit extends NpdTerms
{
    use MessagesTrait;

    // Page ID
    public $PageID = "edit";

    // Project ID
    public $ProjectID = PROJECT_ID;

    // Table name
    public $TableName = 'npd_terms';

    // Page object name
    public $PageObjName = "NpdTermsEdit";

    // Rendering View
    public $RenderingView = false;

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
    public $FormClassName = "ew-horizontal ew-form ew-edit-form";
    public $IsModal = false;
    public $IsMobileOrModal = false;
    public $DbMasterFilter;
    public $DbDetailFilter;
    public $HashValue; // Hash Value
    public $DisplayRecords = 1;
    public $StartRecord;
    public $StopRecord;
    public $TotalRecords = 0;
    public $RecordRange = 10;
    public $RecordCount;

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

        // Create form object
        $CurrentForm = new HttpForm();
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
        $this->IsMobileOrModal = IsMobile() || $this->IsModal;
        $this->FormClassName = "ew-form ew-edit-form ew-horizontal";
        $loaded = false;
        $postBack = false;

        // Set up current action and primary key
        if (IsApi()) {
            // Load key values
            $loaded = true;
            if (($keyValue = Get("id") ?? Key(0) ?? Route(2)) !== null) {
                $this->id->setQueryStringValue($keyValue);
                $this->id->setOldValue($this->id->QueryStringValue);
            } elseif (Post("id") !== null) {
                $this->id->setFormValue(Post("id"));
                $this->id->setOldValue($this->id->FormValue);
            } else {
                $loaded = false; // Unable to load key
            }

            // Load record
            if ($loaded) {
                $loaded = $this->loadRow();
            }
            if (!$loaded) {
                $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
                $this->terminate();
                return;
            }
            $this->CurrentAction = "update"; // Update record directly
            $this->OldKey = $this->getKey(true); // Get from CurrentValue
            $postBack = true;
        } else {
            if (Post("action") !== null) {
                $this->CurrentAction = Post("action"); // Get action code
                if (!$this->isShow()) { // Not reload record, handle as postback
                    $postBack = true;
                }

                // Get key from Form
                $this->setKey(Post($this->OldKeyName), $this->isShow());
            } else {
                $this->CurrentAction = "show"; // Default action is display

                // Load key from QueryString
                $loadByQuery = false;
                if (($keyValue = Get("id") ?? Route("id")) !== null) {
                    $this->id->setQueryStringValue($keyValue);
                    $loadByQuery = true;
                } else {
                    $this->id->CurrentValue = null;
                }
            }

            // Load recordset
            if ($this->isShow()) {
                // Load current record
                $loaded = $this->loadRow();
                $this->OldKey = $loaded ? $this->getKey(true) : ""; // Get from CurrentValue
            }
        }

        // Process form if post back
        if ($postBack) {
            $this->loadFormValues(); // Get form values
        }

        // Validate form if post back
        if ($postBack) {
            if (!$this->validateForm()) {
                $this->EventCancelled = true; // Event cancelled
                $this->restoreFormValues();
                if (IsApi()) {
                    $this->terminate();
                    return;
                } else {
                    $this->CurrentAction = ""; // Form error, reset action
                }
            }
        }

        // Perform current action
        switch ($this->CurrentAction) {
            case "show": // Get a record to display
                if (!$loaded) { // Load record based on key
                    if ($this->getFailureMessage() == "") {
                        $this->setFailureMessage($Language->phrase("NoRecord")); // No record found
                    }
                    $this->terminate("NpdTermsList"); // No matching record, return to list
                    return;
                }
                break;
            case "update": // Update
                $returnUrl = $this->getReturnUrl();
                if (GetPageName($returnUrl) == "NpdTermsList") {
                    $returnUrl = $this->addMasterUrl($returnUrl); // List page, return to List page with correct master key if necessary
                }
                $this->SendEmail = true; // Send email on update success
                if ($this->editRow()) { // Update record based on key
                    if ($this->getSuccessMessage() == "") {
                        $this->setSuccessMessage($Language->phrase("UpdateSuccess")); // Update success
                    }
                    if (IsApi()) {
                        $this->terminate(true);
                        return;
                    } else {
                        $this->terminate($returnUrl); // Return to caller
                        return;
                    }
                } elseif (IsApi()) { // API request, return
                    $this->terminate();
                    return;
                } elseif ($this->getFailureMessage() == $Language->phrase("NoRecord")) {
                    $this->terminate($returnUrl); // Return to caller
                    return;
                } else {
                    $this->EventCancelled = true; // Event cancelled
                    $this->restoreFormValues(); // Restore form values if update failed
                }
        }

        // Set up Breadcrumb
        $this->setupBreadcrumb();

        // Render the record
        $this->RowType = ROWTYPE_EDIT; // Render as Edit
        $this->resetAttributes();
        $this->renderRow();

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

    // Get upload files
    protected function getUploadFiles()
    {
        global $CurrentForm, $Language;
    }

    // Load form values
    protected function loadFormValues()
    {
        // Load from form
        global $CurrentForm;

        // Check field name 'id' first before field var 'x_id'
        $val = $CurrentForm->hasValue("id") ? $CurrentForm->getValue("id") : $CurrentForm->getValue("x_id");
        if (!$this->id->IsDetailKey) {
            $this->id->setFormValue($val);
        }

        // Check field name 'idnpd' first before field var 'x_idnpd'
        $val = $CurrentForm->hasValue("idnpd") ? $CurrentForm->getValue("idnpd") : $CurrentForm->getValue("x_idnpd");
        if (!$this->idnpd->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->idnpd->Visible = false; // Disable update for API request
            } else {
                $this->idnpd->setFormValue($val);
            }
        }

        // Check field name 'status' first before field var 'x_status'
        $val = $CurrentForm->hasValue("status") ? $CurrentForm->getValue("status") : $CurrentForm->getValue("x_status");
        if (!$this->status->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->status->Visible = false; // Disable update for API request
            } else {
                $this->status->setFormValue($val);
            }
        }

        // Check field name 'tglsubmit' first before field var 'x_tglsubmit'
        $val = $CurrentForm->hasValue("tglsubmit") ? $CurrentForm->getValue("tglsubmit") : $CurrentForm->getValue("x_tglsubmit");
        if (!$this->tglsubmit->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tglsubmit->Visible = false; // Disable update for API request
            } else {
                $this->tglsubmit->setFormValue($val);
            }
            $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        }

        // Check field name 'sifatorder' first before field var 'x_sifatorder'
        $val = $CurrentForm->hasValue("sifatorder") ? $CurrentForm->getValue("sifatorder") : $CurrentForm->getValue("x_sifatorder");
        if (!$this->sifatorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->sifatorder->Visible = false; // Disable update for API request
            } else {
                $this->sifatorder->setFormValue($val);
            }
        }

        // Check field name 'ukuranutama' first before field var 'x_ukuranutama'
        $val = $CurrentForm->hasValue("ukuranutama") ? $CurrentForm->getValue("ukuranutama") : $CurrentForm->getValue("x_ukuranutama");
        if (!$this->ukuranutama->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuranutama->Visible = false; // Disable update for API request
            } else {
                $this->ukuranutama->setFormValue($val);
            }
        }

        // Check field name 'utamahargaisipcs' first before field var 'x_utamahargaisipcs'
        $val = $CurrentForm->hasValue("utamahargaisipcs") ? $CurrentForm->getValue("utamahargaisipcs") : $CurrentForm->getValue("x_utamahargaisipcs");
        if (!$this->utamahargaisipcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargaisipcs->Visible = false; // Disable update for API request
            } else {
                $this->utamahargaisipcs->setFormValue($val);
            }
        }

        // Check field name 'utamahargaprimerpcs' first before field var 'x_utamahargaprimerpcs'
        $val = $CurrentForm->hasValue("utamahargaprimerpcs") ? $CurrentForm->getValue("utamahargaprimerpcs") : $CurrentForm->getValue("x_utamahargaprimerpcs");
        if (!$this->utamahargaprimerpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargaprimerpcs->Visible = false; // Disable update for API request
            } else {
                $this->utamahargaprimerpcs->setFormValue($val);
            }
        }

        // Check field name 'utamahargasekunderpcs' first before field var 'x_utamahargasekunderpcs'
        $val = $CurrentForm->hasValue("utamahargasekunderpcs") ? $CurrentForm->getValue("utamahargasekunderpcs") : $CurrentForm->getValue("x_utamahargasekunderpcs");
        if (!$this->utamahargasekunderpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargasekunderpcs->Visible = false; // Disable update for API request
            } else {
                $this->utamahargasekunderpcs->setFormValue($val);
            }
        }

        // Check field name 'utamahargalabelpcs' first before field var 'x_utamahargalabelpcs'
        $val = $CurrentForm->hasValue("utamahargalabelpcs") ? $CurrentForm->getValue("utamahargalabelpcs") : $CurrentForm->getValue("x_utamahargalabelpcs");
        if (!$this->utamahargalabelpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargalabelpcs->Visible = false; // Disable update for API request
            } else {
                $this->utamahargalabelpcs->setFormValue($val);
            }
        }

        // Check field name 'utamahargatotalpcs' first before field var 'x_utamahargatotalpcs'
        $val = $CurrentForm->hasValue("utamahargatotalpcs") ? $CurrentForm->getValue("utamahargatotalpcs") : $CurrentForm->getValue("x_utamahargatotalpcs");
        if (!$this->utamahargatotalpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargatotalpcs->Visible = false; // Disable update for API request
            } else {
                $this->utamahargatotalpcs->setFormValue($val);
            }
        }

        // Check field name 'utamahargaisiorder' first before field var 'x_utamahargaisiorder'
        $val = $CurrentForm->hasValue("utamahargaisiorder") ? $CurrentForm->getValue("utamahargaisiorder") : $CurrentForm->getValue("x_utamahargaisiorder");
        if (!$this->utamahargaisiorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargaisiorder->Visible = false; // Disable update for API request
            } else {
                $this->utamahargaisiorder->setFormValue($val);
            }
        }

        // Check field name 'utamahargaprimerorder' first before field var 'x_utamahargaprimerorder'
        $val = $CurrentForm->hasValue("utamahargaprimerorder") ? $CurrentForm->getValue("utamahargaprimerorder") : $CurrentForm->getValue("x_utamahargaprimerorder");
        if (!$this->utamahargaprimerorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargaprimerorder->Visible = false; // Disable update for API request
            } else {
                $this->utamahargaprimerorder->setFormValue($val);
            }
        }

        // Check field name 'utamahargasekunderorder' first before field var 'x_utamahargasekunderorder'
        $val = $CurrentForm->hasValue("utamahargasekunderorder") ? $CurrentForm->getValue("utamahargasekunderorder") : $CurrentForm->getValue("x_utamahargasekunderorder");
        if (!$this->utamahargasekunderorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargasekunderorder->Visible = false; // Disable update for API request
            } else {
                $this->utamahargasekunderorder->setFormValue($val);
            }
        }

        // Check field name 'utamahargalabelorder' first before field var 'x_utamahargalabelorder'
        $val = $CurrentForm->hasValue("utamahargalabelorder") ? $CurrentForm->getValue("utamahargalabelorder") : $CurrentForm->getValue("x_utamahargalabelorder");
        if (!$this->utamahargalabelorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargalabelorder->Visible = false; // Disable update for API request
            } else {
                $this->utamahargalabelorder->setFormValue($val);
            }
        }

        // Check field name 'utamahargatotalorder' first before field var 'x_utamahargatotalorder'
        $val = $CurrentForm->hasValue("utamahargatotalorder") ? $CurrentForm->getValue("utamahargatotalorder") : $CurrentForm->getValue("x_utamahargatotalorder");
        if (!$this->utamahargatotalorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->utamahargatotalorder->Visible = false; // Disable update for API request
            } else {
                $this->utamahargatotalorder->setFormValue($val);
            }
        }

        // Check field name 'ukuranlain' first before field var 'x_ukuranlain'
        $val = $CurrentForm->hasValue("ukuranlain") ? $CurrentForm->getValue("ukuranlain") : $CurrentForm->getValue("x_ukuranlain");
        if (!$this->ukuranlain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->ukuranlain->Visible = false; // Disable update for API request
            } else {
                $this->ukuranlain->setFormValue($val);
            }
        }

        // Check field name 'lainhargaisipcs' first before field var 'x_lainhargaisipcs'
        $val = $CurrentForm->hasValue("lainhargaisipcs") ? $CurrentForm->getValue("lainhargaisipcs") : $CurrentForm->getValue("x_lainhargaisipcs");
        if (!$this->lainhargaisipcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargaisipcs->Visible = false; // Disable update for API request
            } else {
                $this->lainhargaisipcs->setFormValue($val);
            }
        }

        // Check field name 'lainhargaprimerpcs' first before field var 'x_lainhargaprimerpcs'
        $val = $CurrentForm->hasValue("lainhargaprimerpcs") ? $CurrentForm->getValue("lainhargaprimerpcs") : $CurrentForm->getValue("x_lainhargaprimerpcs");
        if (!$this->lainhargaprimerpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargaprimerpcs->Visible = false; // Disable update for API request
            } else {
                $this->lainhargaprimerpcs->setFormValue($val);
            }
        }

        // Check field name 'lainhargasekunderpcs' first before field var 'x_lainhargasekunderpcs'
        $val = $CurrentForm->hasValue("lainhargasekunderpcs") ? $CurrentForm->getValue("lainhargasekunderpcs") : $CurrentForm->getValue("x_lainhargasekunderpcs");
        if (!$this->lainhargasekunderpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargasekunderpcs->Visible = false; // Disable update for API request
            } else {
                $this->lainhargasekunderpcs->setFormValue($val);
            }
        }

        // Check field name 'lainhargalabelpcs' first before field var 'x_lainhargalabelpcs'
        $val = $CurrentForm->hasValue("lainhargalabelpcs") ? $CurrentForm->getValue("lainhargalabelpcs") : $CurrentForm->getValue("x_lainhargalabelpcs");
        if (!$this->lainhargalabelpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargalabelpcs->Visible = false; // Disable update for API request
            } else {
                $this->lainhargalabelpcs->setFormValue($val);
            }
        }

        // Check field name 'lainhargatotalpcs' first before field var 'x_lainhargatotalpcs'
        $val = $CurrentForm->hasValue("lainhargatotalpcs") ? $CurrentForm->getValue("lainhargatotalpcs") : $CurrentForm->getValue("x_lainhargatotalpcs");
        if (!$this->lainhargatotalpcs->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargatotalpcs->Visible = false; // Disable update for API request
            } else {
                $this->lainhargatotalpcs->setFormValue($val);
            }
        }

        // Check field name 'lainhargaisiorder' first before field var 'x_lainhargaisiorder'
        $val = $CurrentForm->hasValue("lainhargaisiorder") ? $CurrentForm->getValue("lainhargaisiorder") : $CurrentForm->getValue("x_lainhargaisiorder");
        if (!$this->lainhargaisiorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargaisiorder->Visible = false; // Disable update for API request
            } else {
                $this->lainhargaisiorder->setFormValue($val);
            }
        }

        // Check field name 'lainhargaprimerorder' first before field var 'x_lainhargaprimerorder'
        $val = $CurrentForm->hasValue("lainhargaprimerorder") ? $CurrentForm->getValue("lainhargaprimerorder") : $CurrentForm->getValue("x_lainhargaprimerorder");
        if (!$this->lainhargaprimerorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargaprimerorder->Visible = false; // Disable update for API request
            } else {
                $this->lainhargaprimerorder->setFormValue($val);
            }
        }

        // Check field name 'lainhargasekunderorder' first before field var 'x_lainhargasekunderorder'
        $val = $CurrentForm->hasValue("lainhargasekunderorder") ? $CurrentForm->getValue("lainhargasekunderorder") : $CurrentForm->getValue("x_lainhargasekunderorder");
        if (!$this->lainhargasekunderorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargasekunderorder->Visible = false; // Disable update for API request
            } else {
                $this->lainhargasekunderorder->setFormValue($val);
            }
        }

        // Check field name 'lainhargalabelorder' first before field var 'x_lainhargalabelorder'
        $val = $CurrentForm->hasValue("lainhargalabelorder") ? $CurrentForm->getValue("lainhargalabelorder") : $CurrentForm->getValue("x_lainhargalabelorder");
        if (!$this->lainhargalabelorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargalabelorder->Visible = false; // Disable update for API request
            } else {
                $this->lainhargalabelorder->setFormValue($val);
            }
        }

        // Check field name 'lainhargatotalorder' first before field var 'x_lainhargatotalorder'
        $val = $CurrentForm->hasValue("lainhargatotalorder") ? $CurrentForm->getValue("lainhargatotalorder") : $CurrentForm->getValue("x_lainhargatotalorder");
        if (!$this->lainhargatotalorder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainhargatotalorder->Visible = false; // Disable update for API request
            } else {
                $this->lainhargatotalorder->setFormValue($val);
            }
        }

        // Check field name 'isibahanaktif' first before field var 'x_isibahanaktif'
        $val = $CurrentForm->hasValue("isibahanaktif") ? $CurrentForm->getValue("isibahanaktif") : $CurrentForm->getValue("x_isibahanaktif");
        if (!$this->isibahanaktif->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isibahanaktif->Visible = false; // Disable update for API request
            } else {
                $this->isibahanaktif->setFormValue($val);
            }
        }

        // Check field name 'isibahanlain' first before field var 'x_isibahanlain'
        $val = $CurrentForm->hasValue("isibahanlain") ? $CurrentForm->getValue("isibahanlain") : $CurrentForm->getValue("x_isibahanlain");
        if (!$this->isibahanlain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isibahanlain->Visible = false; // Disable update for API request
            } else {
                $this->isibahanlain->setFormValue($val);
            }
        }

        // Check field name 'isiparfum' first before field var 'x_isiparfum'
        $val = $CurrentForm->hasValue("isiparfum") ? $CurrentForm->getValue("isiparfum") : $CurrentForm->getValue("x_isiparfum");
        if (!$this->isiparfum->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isiparfum->Visible = false; // Disable update for API request
            } else {
                $this->isiparfum->setFormValue($val);
            }
        }

        // Check field name 'isiestetika' first before field var 'x_isiestetika'
        $val = $CurrentForm->hasValue("isiestetika") ? $CurrentForm->getValue("isiestetika") : $CurrentForm->getValue("x_isiestetika");
        if (!$this->isiestetika->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->isiestetika->Visible = false; // Disable update for API request
            } else {
                $this->isiestetika->setFormValue($val);
            }
        }

        // Check field name 'kemasanwadah' first before field var 'x_kemasanwadah'
        $val = $CurrentForm->hasValue("kemasanwadah") ? $CurrentForm->getValue("kemasanwadah") : $CurrentForm->getValue("x_kemasanwadah");
        if (!$this->kemasanwadah->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasanwadah->Visible = false; // Disable update for API request
            } else {
                $this->kemasanwadah->setFormValue($val);
            }
        }

        // Check field name 'kemasantutup' first before field var 'x_kemasantutup'
        $val = $CurrentForm->hasValue("kemasantutup") ? $CurrentForm->getValue("kemasantutup") : $CurrentForm->getValue("x_kemasantutup");
        if (!$this->kemasantutup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasantutup->Visible = false; // Disable update for API request
            } else {
                $this->kemasantutup->setFormValue($val);
            }
        }

        // Check field name 'kemasansekunder' first before field var 'x_kemasansekunder'
        $val = $CurrentForm->hasValue("kemasansekunder") ? $CurrentForm->getValue("kemasansekunder") : $CurrentForm->getValue("x_kemasansekunder");
        if (!$this->kemasansekunder->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->kemasansekunder->Visible = false; // Disable update for API request
            } else {
                $this->kemasansekunder->setFormValue($val);
            }
        }

        // Check field name 'desainlabel' first before field var 'x_desainlabel'
        $val = $CurrentForm->hasValue("desainlabel") ? $CurrentForm->getValue("desainlabel") : $CurrentForm->getValue("x_desainlabel");
        if (!$this->desainlabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->desainlabel->Visible = false; // Disable update for API request
            } else {
                $this->desainlabel->setFormValue($val);
            }
        }

        // Check field name 'cetaklabel' first before field var 'x_cetaklabel'
        $val = $CurrentForm->hasValue("cetaklabel") ? $CurrentForm->getValue("cetaklabel") : $CurrentForm->getValue("x_cetaklabel");
        if (!$this->cetaklabel->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->cetaklabel->Visible = false; // Disable update for API request
            } else {
                $this->cetaklabel->setFormValue($val);
            }
        }

        // Check field name 'lainlain' first before field var 'x_lainlain'
        $val = $CurrentForm->hasValue("lainlain") ? $CurrentForm->getValue("lainlain") : $CurrentForm->getValue("x_lainlain");
        if (!$this->lainlain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->lainlain->Visible = false; // Disable update for API request
            } else {
                $this->lainlain->setFormValue($val);
            }
        }

        // Check field name 'deliverypickup' first before field var 'x_deliverypickup'
        $val = $CurrentForm->hasValue("deliverypickup") ? $CurrentForm->getValue("deliverypickup") : $CurrentForm->getValue("x_deliverypickup");
        if (!$this->deliverypickup->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deliverypickup->Visible = false; // Disable update for API request
            } else {
                $this->deliverypickup->setFormValue($val);
            }
        }

        // Check field name 'deliverysinglepoint' first before field var 'x_deliverysinglepoint'
        $val = $CurrentForm->hasValue("deliverysinglepoint") ? $CurrentForm->getValue("deliverysinglepoint") : $CurrentForm->getValue("x_deliverysinglepoint");
        if (!$this->deliverysinglepoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deliverysinglepoint->Visible = false; // Disable update for API request
            } else {
                $this->deliverysinglepoint->setFormValue($val);
            }
        }

        // Check field name 'deliverymultipoint' first before field var 'x_deliverymultipoint'
        $val = $CurrentForm->hasValue("deliverymultipoint") ? $CurrentForm->getValue("deliverymultipoint") : $CurrentForm->getValue("x_deliverymultipoint");
        if (!$this->deliverymultipoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deliverymultipoint->Visible = false; // Disable update for API request
            } else {
                $this->deliverymultipoint->setFormValue($val);
            }
        }

        // Check field name 'deliveryjumlahpoint' first before field var 'x_deliveryjumlahpoint'
        $val = $CurrentForm->hasValue("deliveryjumlahpoint") ? $CurrentForm->getValue("deliveryjumlahpoint") : $CurrentForm->getValue("x_deliveryjumlahpoint");
        if (!$this->deliveryjumlahpoint->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deliveryjumlahpoint->Visible = false; // Disable update for API request
            } else {
                $this->deliveryjumlahpoint->setFormValue($val);
            }
        }

        // Check field name 'deliverytermslain' first before field var 'x_deliverytermslain'
        $val = $CurrentForm->hasValue("deliverytermslain") ? $CurrentForm->getValue("deliverytermslain") : $CurrentForm->getValue("x_deliverytermslain");
        if (!$this->deliverytermslain->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->deliverytermslain->Visible = false; // Disable update for API request
            } else {
                $this->deliverytermslain->setFormValue($val);
            }
        }

        // Check field name 'catatankhusus' first before field var 'x_catatankhusus'
        $val = $CurrentForm->hasValue("catatankhusus") ? $CurrentForm->getValue("catatankhusus") : $CurrentForm->getValue("x_catatankhusus");
        if (!$this->catatankhusus->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->catatankhusus->Visible = false; // Disable update for API request
            } else {
                $this->catatankhusus->setFormValue($val);
            }
        }

        // Check field name 'dibuatdi' first before field var 'x_dibuatdi'
        $val = $CurrentForm->hasValue("dibuatdi") ? $CurrentForm->getValue("dibuatdi") : $CurrentForm->getValue("x_dibuatdi");
        if (!$this->dibuatdi->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->dibuatdi->Visible = false; // Disable update for API request
            } else {
                $this->dibuatdi->setFormValue($val);
            }
        }

        // Check field name 'tanggal' first before field var 'x_tanggal'
        $val = $CurrentForm->hasValue("tanggal") ? $CurrentForm->getValue("tanggal") : $CurrentForm->getValue("x_tanggal");
        if (!$this->tanggal->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->tanggal->Visible = false; // Disable update for API request
            } else {
                $this->tanggal->setFormValue($val);
            }
            $this->tanggal->CurrentValue = UnFormatDateTime($this->tanggal->CurrentValue, 0);
        }

        // Check field name 'created_by' first before field var 'x_created_by'
        $val = $CurrentForm->hasValue("created_by") ? $CurrentForm->getValue("created_by") : $CurrentForm->getValue("x_created_by");
        if (!$this->created_by->IsDetailKey) {
            if (IsApi() && $val === null) {
                $this->created_by->Visible = false; // Disable update for API request
            } else {
                $this->created_by->setFormValue($val);
            }
        }
    }

    // Restore form values
    public function restoreFormValues()
    {
        global $CurrentForm;
        $this->id->CurrentValue = $this->id->FormValue;
        $this->idnpd->CurrentValue = $this->idnpd->FormValue;
        $this->status->CurrentValue = $this->status->FormValue;
        $this->tglsubmit->CurrentValue = $this->tglsubmit->FormValue;
        $this->tglsubmit->CurrentValue = UnFormatDateTime($this->tglsubmit->CurrentValue, 0);
        $this->sifatorder->CurrentValue = $this->sifatorder->FormValue;
        $this->ukuranutama->CurrentValue = $this->ukuranutama->FormValue;
        $this->utamahargaisipcs->CurrentValue = $this->utamahargaisipcs->FormValue;
        $this->utamahargaprimerpcs->CurrentValue = $this->utamahargaprimerpcs->FormValue;
        $this->utamahargasekunderpcs->CurrentValue = $this->utamahargasekunderpcs->FormValue;
        $this->utamahargalabelpcs->CurrentValue = $this->utamahargalabelpcs->FormValue;
        $this->utamahargatotalpcs->CurrentValue = $this->utamahargatotalpcs->FormValue;
        $this->utamahargaisiorder->CurrentValue = $this->utamahargaisiorder->FormValue;
        $this->utamahargaprimerorder->CurrentValue = $this->utamahargaprimerorder->FormValue;
        $this->utamahargasekunderorder->CurrentValue = $this->utamahargasekunderorder->FormValue;
        $this->utamahargalabelorder->CurrentValue = $this->utamahargalabelorder->FormValue;
        $this->utamahargatotalorder->CurrentValue = $this->utamahargatotalorder->FormValue;
        $this->ukuranlain->CurrentValue = $this->ukuranlain->FormValue;
        $this->lainhargaisipcs->CurrentValue = $this->lainhargaisipcs->FormValue;
        $this->lainhargaprimerpcs->CurrentValue = $this->lainhargaprimerpcs->FormValue;
        $this->lainhargasekunderpcs->CurrentValue = $this->lainhargasekunderpcs->FormValue;
        $this->lainhargalabelpcs->CurrentValue = $this->lainhargalabelpcs->FormValue;
        $this->lainhargatotalpcs->CurrentValue = $this->lainhargatotalpcs->FormValue;
        $this->lainhargaisiorder->CurrentValue = $this->lainhargaisiorder->FormValue;
        $this->lainhargaprimerorder->CurrentValue = $this->lainhargaprimerorder->FormValue;
        $this->lainhargasekunderorder->CurrentValue = $this->lainhargasekunderorder->FormValue;
        $this->lainhargalabelorder->CurrentValue = $this->lainhargalabelorder->FormValue;
        $this->lainhargatotalorder->CurrentValue = $this->lainhargatotalorder->FormValue;
        $this->isibahanaktif->CurrentValue = $this->isibahanaktif->FormValue;
        $this->isibahanlain->CurrentValue = $this->isibahanlain->FormValue;
        $this->isiparfum->CurrentValue = $this->isiparfum->FormValue;
        $this->isiestetika->CurrentValue = $this->isiestetika->FormValue;
        $this->kemasanwadah->CurrentValue = $this->kemasanwadah->FormValue;
        $this->kemasantutup->CurrentValue = $this->kemasantutup->FormValue;
        $this->kemasansekunder->CurrentValue = $this->kemasansekunder->FormValue;
        $this->desainlabel->CurrentValue = $this->desainlabel->FormValue;
        $this->cetaklabel->CurrentValue = $this->cetaklabel->FormValue;
        $this->lainlain->CurrentValue = $this->lainlain->FormValue;
        $this->deliverypickup->CurrentValue = $this->deliverypickup->FormValue;
        $this->deliverysinglepoint->CurrentValue = $this->deliverysinglepoint->FormValue;
        $this->deliverymultipoint->CurrentValue = $this->deliverymultipoint->FormValue;
        $this->deliveryjumlahpoint->CurrentValue = $this->deliveryjumlahpoint->FormValue;
        $this->deliverytermslain->CurrentValue = $this->deliverytermslain->FormValue;
        $this->catatankhusus->CurrentValue = $this->catatankhusus->FormValue;
        $this->dibuatdi->CurrentValue = $this->dibuatdi->FormValue;
        $this->tanggal->CurrentValue = $this->tanggal->FormValue;
        $this->tanggal->CurrentValue = UnFormatDateTime($this->tanggal->CurrentValue, 0);
        $this->created_by->CurrentValue = $this->created_by->FormValue;
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
        } elseif ($this->RowType == ROWTYPE_EDIT) {
            // id
            $this->id->EditAttrs["class"] = "form-control";
            $this->id->EditCustomAttributes = "";
            $this->id->EditValue = $this->id->CurrentValue;
            $this->id->ViewCustomAttributes = "";

            // idnpd
            $this->idnpd->EditAttrs["class"] = "form-control";
            $this->idnpd->EditCustomAttributes = "";
            $this->idnpd->EditValue = HtmlEncode($this->idnpd->CurrentValue);
            $this->idnpd->PlaceHolder = RemoveHtml($this->idnpd->caption());

            // status
            $this->status->EditAttrs["class"] = "form-control";
            $this->status->EditCustomAttributes = "";
            if (!$this->status->Raw) {
                $this->status->CurrentValue = HtmlDecode($this->status->CurrentValue);
            }
            $this->status->EditValue = HtmlEncode($this->status->CurrentValue);
            $this->status->PlaceHolder = RemoveHtml($this->status->caption());

            // tglsubmit
            $this->tglsubmit->EditAttrs["class"] = "form-control";
            $this->tglsubmit->EditCustomAttributes = "";
            $this->tglsubmit->EditValue = HtmlEncode(FormatDateTime($this->tglsubmit->CurrentValue, 8));
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
            $this->ukuranutama->EditValue = HtmlEncode($this->ukuranutama->CurrentValue);
            $this->ukuranutama->PlaceHolder = RemoveHtml($this->ukuranutama->caption());

            // utamahargaisipcs
            $this->utamahargaisipcs->EditAttrs["class"] = "form-control";
            $this->utamahargaisipcs->EditCustomAttributes = "";
            $this->utamahargaisipcs->EditValue = HtmlEncode($this->utamahargaisipcs->CurrentValue);
            $this->utamahargaisipcs->PlaceHolder = RemoveHtml($this->utamahargaisipcs->caption());

            // utamahargaprimerpcs
            $this->utamahargaprimerpcs->EditAttrs["class"] = "form-control";
            $this->utamahargaprimerpcs->EditCustomAttributes = "";
            $this->utamahargaprimerpcs->EditValue = HtmlEncode($this->utamahargaprimerpcs->CurrentValue);
            $this->utamahargaprimerpcs->PlaceHolder = RemoveHtml($this->utamahargaprimerpcs->caption());

            // utamahargasekunderpcs
            $this->utamahargasekunderpcs->EditAttrs["class"] = "form-control";
            $this->utamahargasekunderpcs->EditCustomAttributes = "";
            $this->utamahargasekunderpcs->EditValue = HtmlEncode($this->utamahargasekunderpcs->CurrentValue);
            $this->utamahargasekunderpcs->PlaceHolder = RemoveHtml($this->utamahargasekunderpcs->caption());

            // utamahargalabelpcs
            $this->utamahargalabelpcs->EditAttrs["class"] = "form-control";
            $this->utamahargalabelpcs->EditCustomAttributes = "";
            $this->utamahargalabelpcs->EditValue = HtmlEncode($this->utamahargalabelpcs->CurrentValue);
            $this->utamahargalabelpcs->PlaceHolder = RemoveHtml($this->utamahargalabelpcs->caption());

            // utamahargatotalpcs
            $this->utamahargatotalpcs->EditAttrs["class"] = "form-control";
            $this->utamahargatotalpcs->EditCustomAttributes = "";
            $this->utamahargatotalpcs->EditValue = HtmlEncode($this->utamahargatotalpcs->CurrentValue);
            $this->utamahargatotalpcs->PlaceHolder = RemoveHtml($this->utamahargatotalpcs->caption());

            // utamahargaisiorder
            $this->utamahargaisiorder->EditAttrs["class"] = "form-control";
            $this->utamahargaisiorder->EditCustomAttributes = "";
            $this->utamahargaisiorder->EditValue = HtmlEncode($this->utamahargaisiorder->CurrentValue);
            $this->utamahargaisiorder->PlaceHolder = RemoveHtml($this->utamahargaisiorder->caption());

            // utamahargaprimerorder
            $this->utamahargaprimerorder->EditAttrs["class"] = "form-control";
            $this->utamahargaprimerorder->EditCustomAttributes = "";
            $this->utamahargaprimerorder->EditValue = HtmlEncode($this->utamahargaprimerorder->CurrentValue);
            $this->utamahargaprimerorder->PlaceHolder = RemoveHtml($this->utamahargaprimerorder->caption());

            // utamahargasekunderorder
            $this->utamahargasekunderorder->EditAttrs["class"] = "form-control";
            $this->utamahargasekunderorder->EditCustomAttributes = "";
            $this->utamahargasekunderorder->EditValue = HtmlEncode($this->utamahargasekunderorder->CurrentValue);
            $this->utamahargasekunderorder->PlaceHolder = RemoveHtml($this->utamahargasekunderorder->caption());

            // utamahargalabelorder
            $this->utamahargalabelorder->EditAttrs["class"] = "form-control";
            $this->utamahargalabelorder->EditCustomAttributes = "";
            $this->utamahargalabelorder->EditValue = HtmlEncode($this->utamahargalabelorder->CurrentValue);
            $this->utamahargalabelorder->PlaceHolder = RemoveHtml($this->utamahargalabelorder->caption());

            // utamahargatotalorder
            $this->utamahargatotalorder->EditAttrs["class"] = "form-control";
            $this->utamahargatotalorder->EditCustomAttributes = "";
            $this->utamahargatotalorder->EditValue = HtmlEncode($this->utamahargatotalorder->CurrentValue);
            $this->utamahargatotalorder->PlaceHolder = RemoveHtml($this->utamahargatotalorder->caption());

            // ukuranlain
            $this->ukuranlain->EditAttrs["class"] = "form-control";
            $this->ukuranlain->EditCustomAttributes = "";
            if (!$this->ukuranlain->Raw) {
                $this->ukuranlain->CurrentValue = HtmlDecode($this->ukuranlain->CurrentValue);
            }
            $this->ukuranlain->EditValue = HtmlEncode($this->ukuranlain->CurrentValue);
            $this->ukuranlain->PlaceHolder = RemoveHtml($this->ukuranlain->caption());

            // lainhargaisipcs
            $this->lainhargaisipcs->EditAttrs["class"] = "form-control";
            $this->lainhargaisipcs->EditCustomAttributes = "";
            $this->lainhargaisipcs->EditValue = HtmlEncode($this->lainhargaisipcs->CurrentValue);
            $this->lainhargaisipcs->PlaceHolder = RemoveHtml($this->lainhargaisipcs->caption());

            // lainhargaprimerpcs
            $this->lainhargaprimerpcs->EditAttrs["class"] = "form-control";
            $this->lainhargaprimerpcs->EditCustomAttributes = "";
            $this->lainhargaprimerpcs->EditValue = HtmlEncode($this->lainhargaprimerpcs->CurrentValue);
            $this->lainhargaprimerpcs->PlaceHolder = RemoveHtml($this->lainhargaprimerpcs->caption());

            // lainhargasekunderpcs
            $this->lainhargasekunderpcs->EditAttrs["class"] = "form-control";
            $this->lainhargasekunderpcs->EditCustomAttributes = "";
            $this->lainhargasekunderpcs->EditValue = HtmlEncode($this->lainhargasekunderpcs->CurrentValue);
            $this->lainhargasekunderpcs->PlaceHolder = RemoveHtml($this->lainhargasekunderpcs->caption());

            // lainhargalabelpcs
            $this->lainhargalabelpcs->EditAttrs["class"] = "form-control";
            $this->lainhargalabelpcs->EditCustomAttributes = "";
            $this->lainhargalabelpcs->EditValue = HtmlEncode($this->lainhargalabelpcs->CurrentValue);
            $this->lainhargalabelpcs->PlaceHolder = RemoveHtml($this->lainhargalabelpcs->caption());

            // lainhargatotalpcs
            $this->lainhargatotalpcs->EditAttrs["class"] = "form-control";
            $this->lainhargatotalpcs->EditCustomAttributes = "";
            $this->lainhargatotalpcs->EditValue = HtmlEncode($this->lainhargatotalpcs->CurrentValue);
            $this->lainhargatotalpcs->PlaceHolder = RemoveHtml($this->lainhargatotalpcs->caption());

            // lainhargaisiorder
            $this->lainhargaisiorder->EditAttrs["class"] = "form-control";
            $this->lainhargaisiorder->EditCustomAttributes = "";
            $this->lainhargaisiorder->EditValue = HtmlEncode($this->lainhargaisiorder->CurrentValue);
            $this->lainhargaisiorder->PlaceHolder = RemoveHtml($this->lainhargaisiorder->caption());

            // lainhargaprimerorder
            $this->lainhargaprimerorder->EditAttrs["class"] = "form-control";
            $this->lainhargaprimerorder->EditCustomAttributes = "";
            $this->lainhargaprimerorder->EditValue = HtmlEncode($this->lainhargaprimerorder->CurrentValue);
            $this->lainhargaprimerorder->PlaceHolder = RemoveHtml($this->lainhargaprimerorder->caption());

            // lainhargasekunderorder
            $this->lainhargasekunderorder->EditAttrs["class"] = "form-control";
            $this->lainhargasekunderorder->EditCustomAttributes = "";
            $this->lainhargasekunderorder->EditValue = HtmlEncode($this->lainhargasekunderorder->CurrentValue);
            $this->lainhargasekunderorder->PlaceHolder = RemoveHtml($this->lainhargasekunderorder->caption());

            // lainhargalabelorder
            $this->lainhargalabelorder->EditAttrs["class"] = "form-control";
            $this->lainhargalabelorder->EditCustomAttributes = "";
            $this->lainhargalabelorder->EditValue = HtmlEncode($this->lainhargalabelorder->CurrentValue);
            $this->lainhargalabelorder->PlaceHolder = RemoveHtml($this->lainhargalabelorder->caption());

            // lainhargatotalorder
            $this->lainhargatotalorder->EditAttrs["class"] = "form-control";
            $this->lainhargatotalorder->EditCustomAttributes = "";
            $this->lainhargatotalorder->EditValue = HtmlEncode($this->lainhargatotalorder->CurrentValue);
            $this->lainhargatotalorder->PlaceHolder = RemoveHtml($this->lainhargatotalorder->caption());

            // isibahanaktif
            $this->isibahanaktif->EditAttrs["class"] = "form-control";
            $this->isibahanaktif->EditCustomAttributes = "";
            if (!$this->isibahanaktif->Raw) {
                $this->isibahanaktif->CurrentValue = HtmlDecode($this->isibahanaktif->CurrentValue);
            }
            $this->isibahanaktif->EditValue = HtmlEncode($this->isibahanaktif->CurrentValue);
            $this->isibahanaktif->PlaceHolder = RemoveHtml($this->isibahanaktif->caption());

            // isibahanlain
            $this->isibahanlain->EditAttrs["class"] = "form-control";
            $this->isibahanlain->EditCustomAttributes = "";
            if (!$this->isibahanlain->Raw) {
                $this->isibahanlain->CurrentValue = HtmlDecode($this->isibahanlain->CurrentValue);
            }
            $this->isibahanlain->EditValue = HtmlEncode($this->isibahanlain->CurrentValue);
            $this->isibahanlain->PlaceHolder = RemoveHtml($this->isibahanlain->caption());

            // isiparfum
            $this->isiparfum->EditAttrs["class"] = "form-control";
            $this->isiparfum->EditCustomAttributes = "";
            if (!$this->isiparfum->Raw) {
                $this->isiparfum->CurrentValue = HtmlDecode($this->isiparfum->CurrentValue);
            }
            $this->isiparfum->EditValue = HtmlEncode($this->isiparfum->CurrentValue);
            $this->isiparfum->PlaceHolder = RemoveHtml($this->isiparfum->caption());

            // isiestetika
            $this->isiestetika->EditAttrs["class"] = "form-control";
            $this->isiestetika->EditCustomAttributes = "";
            if (!$this->isiestetika->Raw) {
                $this->isiestetika->CurrentValue = HtmlDecode($this->isiestetika->CurrentValue);
            }
            $this->isiestetika->EditValue = HtmlEncode($this->isiestetika->CurrentValue);
            $this->isiestetika->PlaceHolder = RemoveHtml($this->isiestetika->caption());

            // kemasanwadah
            $this->kemasanwadah->EditAttrs["class"] = "form-control";
            $this->kemasanwadah->EditCustomAttributes = "";
            $this->kemasanwadah->EditValue = HtmlEncode($this->kemasanwadah->CurrentValue);
            $this->kemasanwadah->PlaceHolder = RemoveHtml($this->kemasanwadah->caption());

            // kemasantutup
            $this->kemasantutup->EditAttrs["class"] = "form-control";
            $this->kemasantutup->EditCustomAttributes = "";
            $this->kemasantutup->EditValue = HtmlEncode($this->kemasantutup->CurrentValue);
            $this->kemasantutup->PlaceHolder = RemoveHtml($this->kemasantutup->caption());

            // kemasansekunder
            $this->kemasansekunder->EditAttrs["class"] = "form-control";
            $this->kemasansekunder->EditCustomAttributes = "";
            if (!$this->kemasansekunder->Raw) {
                $this->kemasansekunder->CurrentValue = HtmlDecode($this->kemasansekunder->CurrentValue);
            }
            $this->kemasansekunder->EditValue = HtmlEncode($this->kemasansekunder->CurrentValue);
            $this->kemasansekunder->PlaceHolder = RemoveHtml($this->kemasansekunder->caption());

            // desainlabel
            $this->desainlabel->EditAttrs["class"] = "form-control";
            $this->desainlabel->EditCustomAttributes = "";
            if (!$this->desainlabel->Raw) {
                $this->desainlabel->CurrentValue = HtmlDecode($this->desainlabel->CurrentValue);
            }
            $this->desainlabel->EditValue = HtmlEncode($this->desainlabel->CurrentValue);
            $this->desainlabel->PlaceHolder = RemoveHtml($this->desainlabel->caption());

            // cetaklabel
            $this->cetaklabel->EditAttrs["class"] = "form-control";
            $this->cetaklabel->EditCustomAttributes = "";
            if (!$this->cetaklabel->Raw) {
                $this->cetaklabel->CurrentValue = HtmlDecode($this->cetaklabel->CurrentValue);
            }
            $this->cetaklabel->EditValue = HtmlEncode($this->cetaklabel->CurrentValue);
            $this->cetaklabel->PlaceHolder = RemoveHtml($this->cetaklabel->caption());

            // lainlain
            $this->lainlain->EditAttrs["class"] = "form-control";
            $this->lainlain->EditCustomAttributes = "";
            if (!$this->lainlain->Raw) {
                $this->lainlain->CurrentValue = HtmlDecode($this->lainlain->CurrentValue);
            }
            $this->lainlain->EditValue = HtmlEncode($this->lainlain->CurrentValue);
            $this->lainlain->PlaceHolder = RemoveHtml($this->lainlain->caption());

            // deliverypickup
            $this->deliverypickup->EditAttrs["class"] = "form-control";
            $this->deliverypickup->EditCustomAttributes = "";
            if (!$this->deliverypickup->Raw) {
                $this->deliverypickup->CurrentValue = HtmlDecode($this->deliverypickup->CurrentValue);
            }
            $this->deliverypickup->EditValue = HtmlEncode($this->deliverypickup->CurrentValue);
            $this->deliverypickup->PlaceHolder = RemoveHtml($this->deliverypickup->caption());

            // deliverysinglepoint
            $this->deliverysinglepoint->EditAttrs["class"] = "form-control";
            $this->deliverysinglepoint->EditCustomAttributes = "";
            if (!$this->deliverysinglepoint->Raw) {
                $this->deliverysinglepoint->CurrentValue = HtmlDecode($this->deliverysinglepoint->CurrentValue);
            }
            $this->deliverysinglepoint->EditValue = HtmlEncode($this->deliverysinglepoint->CurrentValue);
            $this->deliverysinglepoint->PlaceHolder = RemoveHtml($this->deliverysinglepoint->caption());

            // deliverymultipoint
            $this->deliverymultipoint->EditAttrs["class"] = "form-control";
            $this->deliverymultipoint->EditCustomAttributes = "";
            if (!$this->deliverymultipoint->Raw) {
                $this->deliverymultipoint->CurrentValue = HtmlDecode($this->deliverymultipoint->CurrentValue);
            }
            $this->deliverymultipoint->EditValue = HtmlEncode($this->deliverymultipoint->CurrentValue);
            $this->deliverymultipoint->PlaceHolder = RemoveHtml($this->deliverymultipoint->caption());

            // deliveryjumlahpoint
            $this->deliveryjumlahpoint->EditAttrs["class"] = "form-control";
            $this->deliveryjumlahpoint->EditCustomAttributes = "";
            if (!$this->deliveryjumlahpoint->Raw) {
                $this->deliveryjumlahpoint->CurrentValue = HtmlDecode($this->deliveryjumlahpoint->CurrentValue);
            }
            $this->deliveryjumlahpoint->EditValue = HtmlEncode($this->deliveryjumlahpoint->CurrentValue);
            $this->deliveryjumlahpoint->PlaceHolder = RemoveHtml($this->deliveryjumlahpoint->caption());

            // deliverytermslain
            $this->deliverytermslain->EditAttrs["class"] = "form-control";
            $this->deliverytermslain->EditCustomAttributes = "";
            if (!$this->deliverytermslain->Raw) {
                $this->deliverytermslain->CurrentValue = HtmlDecode($this->deliverytermslain->CurrentValue);
            }
            $this->deliverytermslain->EditValue = HtmlEncode($this->deliverytermslain->CurrentValue);
            $this->deliverytermslain->PlaceHolder = RemoveHtml($this->deliverytermslain->caption());

            // catatankhusus
            $this->catatankhusus->EditAttrs["class"] = "form-control";
            $this->catatankhusus->EditCustomAttributes = "";
            if (!$this->catatankhusus->Raw) {
                $this->catatankhusus->CurrentValue = HtmlDecode($this->catatankhusus->CurrentValue);
            }
            $this->catatankhusus->EditValue = HtmlEncode($this->catatankhusus->CurrentValue);
            $this->catatankhusus->PlaceHolder = RemoveHtml($this->catatankhusus->caption());

            // dibuatdi
            $this->dibuatdi->EditAttrs["class"] = "form-control";
            $this->dibuatdi->EditCustomAttributes = "";
            if (!$this->dibuatdi->Raw) {
                $this->dibuatdi->CurrentValue = HtmlDecode($this->dibuatdi->CurrentValue);
            }
            $this->dibuatdi->EditValue = HtmlEncode($this->dibuatdi->CurrentValue);
            $this->dibuatdi->PlaceHolder = RemoveHtml($this->dibuatdi->caption());

            // tanggal
            $this->tanggal->EditAttrs["class"] = "form-control";
            $this->tanggal->EditCustomAttributes = "";
            $this->tanggal->EditValue = HtmlEncode(FormatDateTime($this->tanggal->CurrentValue, 8));
            $this->tanggal->PlaceHolder = RemoveHtml($this->tanggal->caption());

            // created_by
            $this->created_by->EditAttrs["class"] = "form-control";
            $this->created_by->EditCustomAttributes = "";
            $this->created_by->EditValue = HtmlEncode($this->created_by->CurrentValue);
            $this->created_by->PlaceHolder = RemoveHtml($this->created_by->caption());

            // Edit refer script

            // id
            $this->id->LinkCustomAttributes = "";
            $this->id->HrefValue = "";

            // idnpd
            $this->idnpd->LinkCustomAttributes = "";
            $this->idnpd->HrefValue = "";

            // status
            $this->status->LinkCustomAttributes = "";
            $this->status->HrefValue = "";

            // tglsubmit
            $this->tglsubmit->LinkCustomAttributes = "";
            $this->tglsubmit->HrefValue = "";

            // sifatorder
            $this->sifatorder->LinkCustomAttributes = "";
            $this->sifatorder->HrefValue = "";

            // ukuranutama
            $this->ukuranutama->LinkCustomAttributes = "";
            $this->ukuranutama->HrefValue = "";

            // utamahargaisipcs
            $this->utamahargaisipcs->LinkCustomAttributes = "";
            $this->utamahargaisipcs->HrefValue = "";

            // utamahargaprimerpcs
            $this->utamahargaprimerpcs->LinkCustomAttributes = "";
            $this->utamahargaprimerpcs->HrefValue = "";

            // utamahargasekunderpcs
            $this->utamahargasekunderpcs->LinkCustomAttributes = "";
            $this->utamahargasekunderpcs->HrefValue = "";

            // utamahargalabelpcs
            $this->utamahargalabelpcs->LinkCustomAttributes = "";
            $this->utamahargalabelpcs->HrefValue = "";

            // utamahargatotalpcs
            $this->utamahargatotalpcs->LinkCustomAttributes = "";
            $this->utamahargatotalpcs->HrefValue = "";

            // utamahargaisiorder
            $this->utamahargaisiorder->LinkCustomAttributes = "";
            $this->utamahargaisiorder->HrefValue = "";

            // utamahargaprimerorder
            $this->utamahargaprimerorder->LinkCustomAttributes = "";
            $this->utamahargaprimerorder->HrefValue = "";

            // utamahargasekunderorder
            $this->utamahargasekunderorder->LinkCustomAttributes = "";
            $this->utamahargasekunderorder->HrefValue = "";

            // utamahargalabelorder
            $this->utamahargalabelorder->LinkCustomAttributes = "";
            $this->utamahargalabelorder->HrefValue = "";

            // utamahargatotalorder
            $this->utamahargatotalorder->LinkCustomAttributes = "";
            $this->utamahargatotalorder->HrefValue = "";

            // ukuranlain
            $this->ukuranlain->LinkCustomAttributes = "";
            $this->ukuranlain->HrefValue = "";

            // lainhargaisipcs
            $this->lainhargaisipcs->LinkCustomAttributes = "";
            $this->lainhargaisipcs->HrefValue = "";

            // lainhargaprimerpcs
            $this->lainhargaprimerpcs->LinkCustomAttributes = "";
            $this->lainhargaprimerpcs->HrefValue = "";

            // lainhargasekunderpcs
            $this->lainhargasekunderpcs->LinkCustomAttributes = "";
            $this->lainhargasekunderpcs->HrefValue = "";

            // lainhargalabelpcs
            $this->lainhargalabelpcs->LinkCustomAttributes = "";
            $this->lainhargalabelpcs->HrefValue = "";

            // lainhargatotalpcs
            $this->lainhargatotalpcs->LinkCustomAttributes = "";
            $this->lainhargatotalpcs->HrefValue = "";

            // lainhargaisiorder
            $this->lainhargaisiorder->LinkCustomAttributes = "";
            $this->lainhargaisiorder->HrefValue = "";

            // lainhargaprimerorder
            $this->lainhargaprimerorder->LinkCustomAttributes = "";
            $this->lainhargaprimerorder->HrefValue = "";

            // lainhargasekunderorder
            $this->lainhargasekunderorder->LinkCustomAttributes = "";
            $this->lainhargasekunderorder->HrefValue = "";

            // lainhargalabelorder
            $this->lainhargalabelorder->LinkCustomAttributes = "";
            $this->lainhargalabelorder->HrefValue = "";

            // lainhargatotalorder
            $this->lainhargatotalorder->LinkCustomAttributes = "";
            $this->lainhargatotalorder->HrefValue = "";

            // isibahanaktif
            $this->isibahanaktif->LinkCustomAttributes = "";
            $this->isibahanaktif->HrefValue = "";

            // isibahanlain
            $this->isibahanlain->LinkCustomAttributes = "";
            $this->isibahanlain->HrefValue = "";

            // isiparfum
            $this->isiparfum->LinkCustomAttributes = "";
            $this->isiparfum->HrefValue = "";

            // isiestetika
            $this->isiestetika->LinkCustomAttributes = "";
            $this->isiestetika->HrefValue = "";

            // kemasanwadah
            $this->kemasanwadah->LinkCustomAttributes = "";
            $this->kemasanwadah->HrefValue = "";

            // kemasantutup
            $this->kemasantutup->LinkCustomAttributes = "";
            $this->kemasantutup->HrefValue = "";

            // kemasansekunder
            $this->kemasansekunder->LinkCustomAttributes = "";
            $this->kemasansekunder->HrefValue = "";

            // desainlabel
            $this->desainlabel->LinkCustomAttributes = "";
            $this->desainlabel->HrefValue = "";

            // cetaklabel
            $this->cetaklabel->LinkCustomAttributes = "";
            $this->cetaklabel->HrefValue = "";

            // lainlain
            $this->lainlain->LinkCustomAttributes = "";
            $this->lainlain->HrefValue = "";

            // deliverypickup
            $this->deliverypickup->LinkCustomAttributes = "";
            $this->deliverypickup->HrefValue = "";

            // deliverysinglepoint
            $this->deliverysinglepoint->LinkCustomAttributes = "";
            $this->deliverysinglepoint->HrefValue = "";

            // deliverymultipoint
            $this->deliverymultipoint->LinkCustomAttributes = "";
            $this->deliverymultipoint->HrefValue = "";

            // deliveryjumlahpoint
            $this->deliveryjumlahpoint->LinkCustomAttributes = "";
            $this->deliveryjumlahpoint->HrefValue = "";

            // deliverytermslain
            $this->deliverytermslain->LinkCustomAttributes = "";
            $this->deliverytermslain->HrefValue = "";

            // catatankhusus
            $this->catatankhusus->LinkCustomAttributes = "";
            $this->catatankhusus->HrefValue = "";

            // dibuatdi
            $this->dibuatdi->LinkCustomAttributes = "";
            $this->dibuatdi->HrefValue = "";

            // tanggal
            $this->tanggal->LinkCustomAttributes = "";
            $this->tanggal->HrefValue = "";

            // created_by
            $this->created_by->LinkCustomAttributes = "";
            $this->created_by->HrefValue = "";
        }
        if ($this->RowType == ROWTYPE_ADD || $this->RowType == ROWTYPE_EDIT || $this->RowType == ROWTYPE_SEARCH) { // Add/Edit/Search row
            $this->setupFieldTitles();
        }

        // Call Row Rendered event
        if ($this->RowType != ROWTYPE_AGGREGATEINIT) {
            $this->rowRendered();
        }
    }

    // Validate form
    protected function validateForm()
    {
        global $Language;

        // Check if validation required
        if (!Config("SERVER_VALIDATE")) {
            return true;
        }
        if ($this->id->Required) {
            if (!$this->id->IsDetailKey && EmptyValue($this->id->FormValue)) {
                $this->id->addErrorMessage(str_replace("%s", $this->id->caption(), $this->id->RequiredErrorMessage));
            }
        }
        if ($this->idnpd->Required) {
            if (!$this->idnpd->IsDetailKey && EmptyValue($this->idnpd->FormValue)) {
                $this->idnpd->addErrorMessage(str_replace("%s", $this->idnpd->caption(), $this->idnpd->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->idnpd->FormValue)) {
            $this->idnpd->addErrorMessage($this->idnpd->getErrorMessage(false));
        }
        if ($this->status->Required) {
            if (!$this->status->IsDetailKey && EmptyValue($this->status->FormValue)) {
                $this->status->addErrorMessage(str_replace("%s", $this->status->caption(), $this->status->RequiredErrorMessage));
            }
        }
        if ($this->tglsubmit->Required) {
            if (!$this->tglsubmit->IsDetailKey && EmptyValue($this->tglsubmit->FormValue)) {
                $this->tglsubmit->addErrorMessage(str_replace("%s", $this->tglsubmit->caption(), $this->tglsubmit->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tglsubmit->FormValue)) {
            $this->tglsubmit->addErrorMessage($this->tglsubmit->getErrorMessage(false));
        }
        if ($this->sifatorder->Required) {
            if ($this->sifatorder->FormValue == "") {
                $this->sifatorder->addErrorMessage(str_replace("%s", $this->sifatorder->caption(), $this->sifatorder->RequiredErrorMessage));
            }
        }
        if ($this->ukuranutama->Required) {
            if (!$this->ukuranutama->IsDetailKey && EmptyValue($this->ukuranutama->FormValue)) {
                $this->ukuranutama->addErrorMessage(str_replace("%s", $this->ukuranutama->caption(), $this->ukuranutama->RequiredErrorMessage));
            }
        }
        if ($this->utamahargaisipcs->Required) {
            if (!$this->utamahargaisipcs->IsDetailKey && EmptyValue($this->utamahargaisipcs->FormValue)) {
                $this->utamahargaisipcs->addErrorMessage(str_replace("%s", $this->utamahargaisipcs->caption(), $this->utamahargaisipcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargaisipcs->FormValue)) {
            $this->utamahargaisipcs->addErrorMessage($this->utamahargaisipcs->getErrorMessage(false));
        }
        if ($this->utamahargaprimerpcs->Required) {
            if (!$this->utamahargaprimerpcs->IsDetailKey && EmptyValue($this->utamahargaprimerpcs->FormValue)) {
                $this->utamahargaprimerpcs->addErrorMessage(str_replace("%s", $this->utamahargaprimerpcs->caption(), $this->utamahargaprimerpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargaprimerpcs->FormValue)) {
            $this->utamahargaprimerpcs->addErrorMessage($this->utamahargaprimerpcs->getErrorMessage(false));
        }
        if ($this->utamahargasekunderpcs->Required) {
            if (!$this->utamahargasekunderpcs->IsDetailKey && EmptyValue($this->utamahargasekunderpcs->FormValue)) {
                $this->utamahargasekunderpcs->addErrorMessage(str_replace("%s", $this->utamahargasekunderpcs->caption(), $this->utamahargasekunderpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargasekunderpcs->FormValue)) {
            $this->utamahargasekunderpcs->addErrorMessage($this->utamahargasekunderpcs->getErrorMessage(false));
        }
        if ($this->utamahargalabelpcs->Required) {
            if (!$this->utamahargalabelpcs->IsDetailKey && EmptyValue($this->utamahargalabelpcs->FormValue)) {
                $this->utamahargalabelpcs->addErrorMessage(str_replace("%s", $this->utamahargalabelpcs->caption(), $this->utamahargalabelpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargalabelpcs->FormValue)) {
            $this->utamahargalabelpcs->addErrorMessage($this->utamahargalabelpcs->getErrorMessage(false));
        }
        if ($this->utamahargatotalpcs->Required) {
            if (!$this->utamahargatotalpcs->IsDetailKey && EmptyValue($this->utamahargatotalpcs->FormValue)) {
                $this->utamahargatotalpcs->addErrorMessage(str_replace("%s", $this->utamahargatotalpcs->caption(), $this->utamahargatotalpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargatotalpcs->FormValue)) {
            $this->utamahargatotalpcs->addErrorMessage($this->utamahargatotalpcs->getErrorMessage(false));
        }
        if ($this->utamahargaisiorder->Required) {
            if (!$this->utamahargaisiorder->IsDetailKey && EmptyValue($this->utamahargaisiorder->FormValue)) {
                $this->utamahargaisiorder->addErrorMessage(str_replace("%s", $this->utamahargaisiorder->caption(), $this->utamahargaisiorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargaisiorder->FormValue)) {
            $this->utamahargaisiorder->addErrorMessage($this->utamahargaisiorder->getErrorMessage(false));
        }
        if ($this->utamahargaprimerorder->Required) {
            if (!$this->utamahargaprimerorder->IsDetailKey && EmptyValue($this->utamahargaprimerorder->FormValue)) {
                $this->utamahargaprimerorder->addErrorMessage(str_replace("%s", $this->utamahargaprimerorder->caption(), $this->utamahargaprimerorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargaprimerorder->FormValue)) {
            $this->utamahargaprimerorder->addErrorMessage($this->utamahargaprimerorder->getErrorMessage(false));
        }
        if ($this->utamahargasekunderorder->Required) {
            if (!$this->utamahargasekunderorder->IsDetailKey && EmptyValue($this->utamahargasekunderorder->FormValue)) {
                $this->utamahargasekunderorder->addErrorMessage(str_replace("%s", $this->utamahargasekunderorder->caption(), $this->utamahargasekunderorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargasekunderorder->FormValue)) {
            $this->utamahargasekunderorder->addErrorMessage($this->utamahargasekunderorder->getErrorMessage(false));
        }
        if ($this->utamahargalabelorder->Required) {
            if (!$this->utamahargalabelorder->IsDetailKey && EmptyValue($this->utamahargalabelorder->FormValue)) {
                $this->utamahargalabelorder->addErrorMessage(str_replace("%s", $this->utamahargalabelorder->caption(), $this->utamahargalabelorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargalabelorder->FormValue)) {
            $this->utamahargalabelorder->addErrorMessage($this->utamahargalabelorder->getErrorMessage(false));
        }
        if ($this->utamahargatotalorder->Required) {
            if (!$this->utamahargatotalorder->IsDetailKey && EmptyValue($this->utamahargatotalorder->FormValue)) {
                $this->utamahargatotalorder->addErrorMessage(str_replace("%s", $this->utamahargatotalorder->caption(), $this->utamahargatotalorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->utamahargatotalorder->FormValue)) {
            $this->utamahargatotalorder->addErrorMessage($this->utamahargatotalorder->getErrorMessage(false));
        }
        if ($this->ukuranlain->Required) {
            if (!$this->ukuranlain->IsDetailKey && EmptyValue($this->ukuranlain->FormValue)) {
                $this->ukuranlain->addErrorMessage(str_replace("%s", $this->ukuranlain->caption(), $this->ukuranlain->RequiredErrorMessage));
            }
        }
        if ($this->lainhargaisipcs->Required) {
            if (!$this->lainhargaisipcs->IsDetailKey && EmptyValue($this->lainhargaisipcs->FormValue)) {
                $this->lainhargaisipcs->addErrorMessage(str_replace("%s", $this->lainhargaisipcs->caption(), $this->lainhargaisipcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargaisipcs->FormValue)) {
            $this->lainhargaisipcs->addErrorMessage($this->lainhargaisipcs->getErrorMessage(false));
        }
        if ($this->lainhargaprimerpcs->Required) {
            if (!$this->lainhargaprimerpcs->IsDetailKey && EmptyValue($this->lainhargaprimerpcs->FormValue)) {
                $this->lainhargaprimerpcs->addErrorMessage(str_replace("%s", $this->lainhargaprimerpcs->caption(), $this->lainhargaprimerpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargaprimerpcs->FormValue)) {
            $this->lainhargaprimerpcs->addErrorMessage($this->lainhargaprimerpcs->getErrorMessage(false));
        }
        if ($this->lainhargasekunderpcs->Required) {
            if (!$this->lainhargasekunderpcs->IsDetailKey && EmptyValue($this->lainhargasekunderpcs->FormValue)) {
                $this->lainhargasekunderpcs->addErrorMessage(str_replace("%s", $this->lainhargasekunderpcs->caption(), $this->lainhargasekunderpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargasekunderpcs->FormValue)) {
            $this->lainhargasekunderpcs->addErrorMessage($this->lainhargasekunderpcs->getErrorMessage(false));
        }
        if ($this->lainhargalabelpcs->Required) {
            if (!$this->lainhargalabelpcs->IsDetailKey && EmptyValue($this->lainhargalabelpcs->FormValue)) {
                $this->lainhargalabelpcs->addErrorMessage(str_replace("%s", $this->lainhargalabelpcs->caption(), $this->lainhargalabelpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargalabelpcs->FormValue)) {
            $this->lainhargalabelpcs->addErrorMessage($this->lainhargalabelpcs->getErrorMessage(false));
        }
        if ($this->lainhargatotalpcs->Required) {
            if (!$this->lainhargatotalpcs->IsDetailKey && EmptyValue($this->lainhargatotalpcs->FormValue)) {
                $this->lainhargatotalpcs->addErrorMessage(str_replace("%s", $this->lainhargatotalpcs->caption(), $this->lainhargatotalpcs->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargatotalpcs->FormValue)) {
            $this->lainhargatotalpcs->addErrorMessage($this->lainhargatotalpcs->getErrorMessage(false));
        }
        if ($this->lainhargaisiorder->Required) {
            if (!$this->lainhargaisiorder->IsDetailKey && EmptyValue($this->lainhargaisiorder->FormValue)) {
                $this->lainhargaisiorder->addErrorMessage(str_replace("%s", $this->lainhargaisiorder->caption(), $this->lainhargaisiorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargaisiorder->FormValue)) {
            $this->lainhargaisiorder->addErrorMessage($this->lainhargaisiorder->getErrorMessage(false));
        }
        if ($this->lainhargaprimerorder->Required) {
            if (!$this->lainhargaprimerorder->IsDetailKey && EmptyValue($this->lainhargaprimerorder->FormValue)) {
                $this->lainhargaprimerorder->addErrorMessage(str_replace("%s", $this->lainhargaprimerorder->caption(), $this->lainhargaprimerorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargaprimerorder->FormValue)) {
            $this->lainhargaprimerorder->addErrorMessage($this->lainhargaprimerorder->getErrorMessage(false));
        }
        if ($this->lainhargasekunderorder->Required) {
            if (!$this->lainhargasekunderorder->IsDetailKey && EmptyValue($this->lainhargasekunderorder->FormValue)) {
                $this->lainhargasekunderorder->addErrorMessage(str_replace("%s", $this->lainhargasekunderorder->caption(), $this->lainhargasekunderorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargasekunderorder->FormValue)) {
            $this->lainhargasekunderorder->addErrorMessage($this->lainhargasekunderorder->getErrorMessage(false));
        }
        if ($this->lainhargalabelorder->Required) {
            if (!$this->lainhargalabelorder->IsDetailKey && EmptyValue($this->lainhargalabelorder->FormValue)) {
                $this->lainhargalabelorder->addErrorMessage(str_replace("%s", $this->lainhargalabelorder->caption(), $this->lainhargalabelorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargalabelorder->FormValue)) {
            $this->lainhargalabelorder->addErrorMessage($this->lainhargalabelorder->getErrorMessage(false));
        }
        if ($this->lainhargatotalorder->Required) {
            if (!$this->lainhargatotalorder->IsDetailKey && EmptyValue($this->lainhargatotalorder->FormValue)) {
                $this->lainhargatotalorder->addErrorMessage(str_replace("%s", $this->lainhargatotalorder->caption(), $this->lainhargatotalorder->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->lainhargatotalorder->FormValue)) {
            $this->lainhargatotalorder->addErrorMessage($this->lainhargatotalorder->getErrorMessage(false));
        }
        if ($this->isibahanaktif->Required) {
            if (!$this->isibahanaktif->IsDetailKey && EmptyValue($this->isibahanaktif->FormValue)) {
                $this->isibahanaktif->addErrorMessage(str_replace("%s", $this->isibahanaktif->caption(), $this->isibahanaktif->RequiredErrorMessage));
            }
        }
        if ($this->isibahanlain->Required) {
            if (!$this->isibahanlain->IsDetailKey && EmptyValue($this->isibahanlain->FormValue)) {
                $this->isibahanlain->addErrorMessage(str_replace("%s", $this->isibahanlain->caption(), $this->isibahanlain->RequiredErrorMessage));
            }
        }
        if ($this->isiparfum->Required) {
            if (!$this->isiparfum->IsDetailKey && EmptyValue($this->isiparfum->FormValue)) {
                $this->isiparfum->addErrorMessage(str_replace("%s", $this->isiparfum->caption(), $this->isiparfum->RequiredErrorMessage));
            }
        }
        if ($this->isiestetika->Required) {
            if (!$this->isiestetika->IsDetailKey && EmptyValue($this->isiestetika->FormValue)) {
                $this->isiestetika->addErrorMessage(str_replace("%s", $this->isiestetika->caption(), $this->isiestetika->RequiredErrorMessage));
            }
        }
        if ($this->kemasanwadah->Required) {
            if (!$this->kemasanwadah->IsDetailKey && EmptyValue($this->kemasanwadah->FormValue)) {
                $this->kemasanwadah->addErrorMessage(str_replace("%s", $this->kemasanwadah->caption(), $this->kemasanwadah->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->kemasanwadah->FormValue)) {
            $this->kemasanwadah->addErrorMessage($this->kemasanwadah->getErrorMessage(false));
        }
        if ($this->kemasantutup->Required) {
            if (!$this->kemasantutup->IsDetailKey && EmptyValue($this->kemasantutup->FormValue)) {
                $this->kemasantutup->addErrorMessage(str_replace("%s", $this->kemasantutup->caption(), $this->kemasantutup->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->kemasantutup->FormValue)) {
            $this->kemasantutup->addErrorMessage($this->kemasantutup->getErrorMessage(false));
        }
        if ($this->kemasansekunder->Required) {
            if (!$this->kemasansekunder->IsDetailKey && EmptyValue($this->kemasansekunder->FormValue)) {
                $this->kemasansekunder->addErrorMessage(str_replace("%s", $this->kemasansekunder->caption(), $this->kemasansekunder->RequiredErrorMessage));
            }
        }
        if ($this->desainlabel->Required) {
            if (!$this->desainlabel->IsDetailKey && EmptyValue($this->desainlabel->FormValue)) {
                $this->desainlabel->addErrorMessage(str_replace("%s", $this->desainlabel->caption(), $this->desainlabel->RequiredErrorMessage));
            }
        }
        if ($this->cetaklabel->Required) {
            if (!$this->cetaklabel->IsDetailKey && EmptyValue($this->cetaklabel->FormValue)) {
                $this->cetaklabel->addErrorMessage(str_replace("%s", $this->cetaklabel->caption(), $this->cetaklabel->RequiredErrorMessage));
            }
        }
        if ($this->lainlain->Required) {
            if (!$this->lainlain->IsDetailKey && EmptyValue($this->lainlain->FormValue)) {
                $this->lainlain->addErrorMessage(str_replace("%s", $this->lainlain->caption(), $this->lainlain->RequiredErrorMessage));
            }
        }
        if ($this->deliverypickup->Required) {
            if (!$this->deliverypickup->IsDetailKey && EmptyValue($this->deliverypickup->FormValue)) {
                $this->deliverypickup->addErrorMessage(str_replace("%s", $this->deliverypickup->caption(), $this->deliverypickup->RequiredErrorMessage));
            }
        }
        if ($this->deliverysinglepoint->Required) {
            if (!$this->deliverysinglepoint->IsDetailKey && EmptyValue($this->deliverysinglepoint->FormValue)) {
                $this->deliverysinglepoint->addErrorMessage(str_replace("%s", $this->deliverysinglepoint->caption(), $this->deliverysinglepoint->RequiredErrorMessage));
            }
        }
        if ($this->deliverymultipoint->Required) {
            if (!$this->deliverymultipoint->IsDetailKey && EmptyValue($this->deliverymultipoint->FormValue)) {
                $this->deliverymultipoint->addErrorMessage(str_replace("%s", $this->deliverymultipoint->caption(), $this->deliverymultipoint->RequiredErrorMessage));
            }
        }
        if ($this->deliveryjumlahpoint->Required) {
            if (!$this->deliveryjumlahpoint->IsDetailKey && EmptyValue($this->deliveryjumlahpoint->FormValue)) {
                $this->deliveryjumlahpoint->addErrorMessage(str_replace("%s", $this->deliveryjumlahpoint->caption(), $this->deliveryjumlahpoint->RequiredErrorMessage));
            }
        }
        if ($this->deliverytermslain->Required) {
            if (!$this->deliverytermslain->IsDetailKey && EmptyValue($this->deliverytermslain->FormValue)) {
                $this->deliverytermslain->addErrorMessage(str_replace("%s", $this->deliverytermslain->caption(), $this->deliverytermslain->RequiredErrorMessage));
            }
        }
        if ($this->catatankhusus->Required) {
            if (!$this->catatankhusus->IsDetailKey && EmptyValue($this->catatankhusus->FormValue)) {
                $this->catatankhusus->addErrorMessage(str_replace("%s", $this->catatankhusus->caption(), $this->catatankhusus->RequiredErrorMessage));
            }
        }
        if ($this->dibuatdi->Required) {
            if (!$this->dibuatdi->IsDetailKey && EmptyValue($this->dibuatdi->FormValue)) {
                $this->dibuatdi->addErrorMessage(str_replace("%s", $this->dibuatdi->caption(), $this->dibuatdi->RequiredErrorMessage));
            }
        }
        if ($this->tanggal->Required) {
            if (!$this->tanggal->IsDetailKey && EmptyValue($this->tanggal->FormValue)) {
                $this->tanggal->addErrorMessage(str_replace("%s", $this->tanggal->caption(), $this->tanggal->RequiredErrorMessage));
            }
        }
        if (!CheckDate($this->tanggal->FormValue)) {
            $this->tanggal->addErrorMessage($this->tanggal->getErrorMessage(false));
        }
        if ($this->created_by->Required) {
            if (!$this->created_by->IsDetailKey && EmptyValue($this->created_by->FormValue)) {
                $this->created_by->addErrorMessage(str_replace("%s", $this->created_by->caption(), $this->created_by->RequiredErrorMessage));
            }
        }
        if (!CheckInteger($this->created_by->FormValue)) {
            $this->created_by->addErrorMessage($this->created_by->getErrorMessage(false));
        }

        // Return validate result
        $validateForm = !$this->hasInvalidFields();

        // Call Form_CustomValidate event
        $formCustomError = "";
        $validateForm = $validateForm && $this->formCustomValidate($formCustomError);
        if ($formCustomError != "") {
            $this->setFailureMessage($formCustomError);
        }
        return $validateForm;
    }

    // Update record based on key values
    protected function editRow()
    {
        global $Security, $Language;
        $oldKeyFilter = $this->getRecordFilter();
        $filter = $this->applyUserIDFilters($oldKeyFilter);
        $conn = $this->getConnection();
        $this->CurrentFilter = $filter;
        $sql = $this->getCurrentSql();
        $rsold = $conn->fetchAssoc($sql);
        $editRow = false;
        if (!$rsold) {
            $this->setFailureMessage($Language->phrase("NoRecord")); // Set no record message
            $editRow = false; // Update Failed
        } else {
            // Save old values
            $this->loadDbValues($rsold);
            $rsnew = [];

            // idnpd
            $this->idnpd->setDbValueDef($rsnew, $this->idnpd->CurrentValue, 0, $this->idnpd->ReadOnly);

            // status
            $this->status->setDbValueDef($rsnew, $this->status->CurrentValue, null, $this->status->ReadOnly);

            // tglsubmit
            $this->tglsubmit->setDbValueDef($rsnew, UnFormatDateTime($this->tglsubmit->CurrentValue, 0), null, $this->tglsubmit->ReadOnly);

            // sifatorder
            $tmpBool = $this->sifatorder->CurrentValue;
            if ($tmpBool != "1" && $tmpBool != "0") {
                $tmpBool = !empty($tmpBool) ? "1" : "0";
            }
            $this->sifatorder->setDbValueDef($rsnew, $tmpBool, 0, $this->sifatorder->ReadOnly);

            // ukuranutama
            $this->ukuranutama->setDbValueDef($rsnew, $this->ukuranutama->CurrentValue, null, $this->ukuranutama->ReadOnly);

            // utamahargaisipcs
            $this->utamahargaisipcs->setDbValueDef($rsnew, $this->utamahargaisipcs->CurrentValue, null, $this->utamahargaisipcs->ReadOnly);

            // utamahargaprimerpcs
            $this->utamahargaprimerpcs->setDbValueDef($rsnew, $this->utamahargaprimerpcs->CurrentValue, null, $this->utamahargaprimerpcs->ReadOnly);

            // utamahargasekunderpcs
            $this->utamahargasekunderpcs->setDbValueDef($rsnew, $this->utamahargasekunderpcs->CurrentValue, null, $this->utamahargasekunderpcs->ReadOnly);

            // utamahargalabelpcs
            $this->utamahargalabelpcs->setDbValueDef($rsnew, $this->utamahargalabelpcs->CurrentValue, null, $this->utamahargalabelpcs->ReadOnly);

            // utamahargatotalpcs
            $this->utamahargatotalpcs->setDbValueDef($rsnew, $this->utamahargatotalpcs->CurrentValue, null, $this->utamahargatotalpcs->ReadOnly);

            // utamahargaisiorder
            $this->utamahargaisiorder->setDbValueDef($rsnew, $this->utamahargaisiorder->CurrentValue, null, $this->utamahargaisiorder->ReadOnly);

            // utamahargaprimerorder
            $this->utamahargaprimerorder->setDbValueDef($rsnew, $this->utamahargaprimerorder->CurrentValue, null, $this->utamahargaprimerorder->ReadOnly);

            // utamahargasekunderorder
            $this->utamahargasekunderorder->setDbValueDef($rsnew, $this->utamahargasekunderorder->CurrentValue, null, $this->utamahargasekunderorder->ReadOnly);

            // utamahargalabelorder
            $this->utamahargalabelorder->setDbValueDef($rsnew, $this->utamahargalabelorder->CurrentValue, null, $this->utamahargalabelorder->ReadOnly);

            // utamahargatotalorder
            $this->utamahargatotalorder->setDbValueDef($rsnew, $this->utamahargatotalorder->CurrentValue, null, $this->utamahargatotalorder->ReadOnly);

            // ukuranlain
            $this->ukuranlain->setDbValueDef($rsnew, $this->ukuranlain->CurrentValue, null, $this->ukuranlain->ReadOnly);

            // lainhargaisipcs
            $this->lainhargaisipcs->setDbValueDef($rsnew, $this->lainhargaisipcs->CurrentValue, null, $this->lainhargaisipcs->ReadOnly);

            // lainhargaprimerpcs
            $this->lainhargaprimerpcs->setDbValueDef($rsnew, $this->lainhargaprimerpcs->CurrentValue, null, $this->lainhargaprimerpcs->ReadOnly);

            // lainhargasekunderpcs
            $this->lainhargasekunderpcs->setDbValueDef($rsnew, $this->lainhargasekunderpcs->CurrentValue, null, $this->lainhargasekunderpcs->ReadOnly);

            // lainhargalabelpcs
            $this->lainhargalabelpcs->setDbValueDef($rsnew, $this->lainhargalabelpcs->CurrentValue, null, $this->lainhargalabelpcs->ReadOnly);

            // lainhargatotalpcs
            $this->lainhargatotalpcs->setDbValueDef($rsnew, $this->lainhargatotalpcs->CurrentValue, null, $this->lainhargatotalpcs->ReadOnly);

            // lainhargaisiorder
            $this->lainhargaisiorder->setDbValueDef($rsnew, $this->lainhargaisiorder->CurrentValue, null, $this->lainhargaisiorder->ReadOnly);

            // lainhargaprimerorder
            $this->lainhargaprimerorder->setDbValueDef($rsnew, $this->lainhargaprimerorder->CurrentValue, null, $this->lainhargaprimerorder->ReadOnly);

            // lainhargasekunderorder
            $this->lainhargasekunderorder->setDbValueDef($rsnew, $this->lainhargasekunderorder->CurrentValue, null, $this->lainhargasekunderorder->ReadOnly);

            // lainhargalabelorder
            $this->lainhargalabelorder->setDbValueDef($rsnew, $this->lainhargalabelorder->CurrentValue, null, $this->lainhargalabelorder->ReadOnly);

            // lainhargatotalorder
            $this->lainhargatotalorder->setDbValueDef($rsnew, $this->lainhargatotalorder->CurrentValue, null, $this->lainhargatotalorder->ReadOnly);

            // isibahanaktif
            $this->isibahanaktif->setDbValueDef($rsnew, $this->isibahanaktif->CurrentValue, null, $this->isibahanaktif->ReadOnly);

            // isibahanlain
            $this->isibahanlain->setDbValueDef($rsnew, $this->isibahanlain->CurrentValue, null, $this->isibahanlain->ReadOnly);

            // isiparfum
            $this->isiparfum->setDbValueDef($rsnew, $this->isiparfum->CurrentValue, null, $this->isiparfum->ReadOnly);

            // isiestetika
            $this->isiestetika->setDbValueDef($rsnew, $this->isiestetika->CurrentValue, null, $this->isiestetika->ReadOnly);

            // kemasanwadah
            $this->kemasanwadah->setDbValueDef($rsnew, $this->kemasanwadah->CurrentValue, null, $this->kemasanwadah->ReadOnly);

            // kemasantutup
            $this->kemasantutup->setDbValueDef($rsnew, $this->kemasantutup->CurrentValue, null, $this->kemasantutup->ReadOnly);

            // kemasansekunder
            $this->kemasansekunder->setDbValueDef($rsnew, $this->kemasansekunder->CurrentValue, null, $this->kemasansekunder->ReadOnly);

            // desainlabel
            $this->desainlabel->setDbValueDef($rsnew, $this->desainlabel->CurrentValue, null, $this->desainlabel->ReadOnly);

            // cetaklabel
            $this->cetaklabel->setDbValueDef($rsnew, $this->cetaklabel->CurrentValue, null, $this->cetaklabel->ReadOnly);

            // lainlain
            $this->lainlain->setDbValueDef($rsnew, $this->lainlain->CurrentValue, null, $this->lainlain->ReadOnly);

            // deliverypickup
            $this->deliverypickup->setDbValueDef($rsnew, $this->deliverypickup->CurrentValue, null, $this->deliverypickup->ReadOnly);

            // deliverysinglepoint
            $this->deliverysinglepoint->setDbValueDef($rsnew, $this->deliverysinglepoint->CurrentValue, null, $this->deliverysinglepoint->ReadOnly);

            // deliverymultipoint
            $this->deliverymultipoint->setDbValueDef($rsnew, $this->deliverymultipoint->CurrentValue, null, $this->deliverymultipoint->ReadOnly);

            // deliveryjumlahpoint
            $this->deliveryjumlahpoint->setDbValueDef($rsnew, $this->deliveryjumlahpoint->CurrentValue, null, $this->deliveryjumlahpoint->ReadOnly);

            // deliverytermslain
            $this->deliverytermslain->setDbValueDef($rsnew, $this->deliverytermslain->CurrentValue, null, $this->deliverytermslain->ReadOnly);

            // catatankhusus
            $this->catatankhusus->setDbValueDef($rsnew, $this->catatankhusus->CurrentValue, null, $this->catatankhusus->ReadOnly);

            // dibuatdi
            $this->dibuatdi->setDbValueDef($rsnew, $this->dibuatdi->CurrentValue, null, $this->dibuatdi->ReadOnly);

            // tanggal
            $this->tanggal->setDbValueDef($rsnew, UnFormatDateTime($this->tanggal->CurrentValue, 0), CurrentDate(), $this->tanggal->ReadOnly);

            // created_by
            $this->created_by->setDbValueDef($rsnew, $this->created_by->CurrentValue, null, $this->created_by->ReadOnly);

            // Call Row Updating event
            $updateRow = $this->rowUpdating($rsold, $rsnew);
            if ($updateRow) {
                if (count($rsnew) > 0) {
                    try {
                        $editRow = $this->update($rsnew, "", $rsold);
                    } catch (\Exception $e) {
                        $this->setFailureMessage($e->getMessage());
                    }
                } else {
                    $editRow = true; // No field to update
                }
                if ($editRow) {
                }
            } else {
                if ($this->getSuccessMessage() != "" || $this->getFailureMessage() != "") {
                    // Use the message, do nothing
                } elseif ($this->CancelMessage != "") {
                    $this->setFailureMessage($this->CancelMessage);
                    $this->CancelMessage = "";
                } else {
                    $this->setFailureMessage($Language->phrase("UpdateCancelled"));
                }
                $editRow = false;
            }
        }

        // Call Row_Updated event
        if ($editRow) {
            $this->rowUpdated($rsold, $rsnew);
        }

        // Clean upload path if any
        if ($editRow) {
        }

        // Write JSON for API request
        if (IsApi() && $editRow) {
            $row = $this->getRecordsFromRecordset([$rsnew], true);
            WriteJson(["success" => true, $this->TableVar => $row]);
        }
        return $editRow;
    }

    // Set up Breadcrumb
    protected function setupBreadcrumb()
    {
        global $Breadcrumb, $Language;
        $Breadcrumb = new Breadcrumb("index");
        $url = CurrentUrl();
        $Breadcrumb->add("list", $this->TableVar, $this->addMasterUrl("NpdTermsList"), "", $this->TableVar, true);
        $pageId = "edit";
        $Breadcrumb->add("edit", $pageId, $url);
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
}
