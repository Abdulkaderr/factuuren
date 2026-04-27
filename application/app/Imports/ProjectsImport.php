<?php

namespace App\Imports;

use App\Models\Project;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsFailures;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ProjectsImport implements ToModel, WithStartRow, WithHeadingRow, WithValidation, SkipsOnFailure {

    use Importable, SkipsFailures;

    private $rows = 0;
    private $settings;
    private $assignedUsers = [];

    public function __construct() {
        $this->settings = \App\Models\Settings::Where('settings_id', 1)->first();
    }

    /**
     * Map Excel row to Project model
     * @param array $row
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row) {

        // Lookup client_id from client name
        $client_id = $this->getClientId($row['clientname'] ?? '');

        // Lookup category_id from category name
        $category_id = $this->getCategoryId($row['category'] ?? '');

        // Transform status value
        $status = $this->transformStatus($row['status'] ?? '');

        // Parse progress value
        $progress = 0;
        if (isset($row['progress'])) {
            $progress = floatval($row['progress']);
        }

        // Transform billing_type
        $billing_type = null;
        if (isset($row['billingtype'])) {
            $billing_value = strtolower(trim($row['billingtype']));
            if ($billing_value === 'hourly' || $billing_value === 'fixed') {
                $billing_type = $billing_value;
            }
        }

        // Parse dates
        $date_start = $this->parseDate($row['startdate'] ?? null);
        $date_due = $this->parseDate($row['duedate'] ?? null);

        // Generate unique ID for this project
        $unique_id = str_unique();

        // Store assigned users for post-processing (indexed by unique_id)
        if (!empty($row['assignedusers'])) {
            $this->assignedUsers[$unique_id] = $row['assignedusers'];
        }

        ++$this->rows;

        return new Project([
            'project_type' => 'project',
            'project_uniqueid' => $unique_id,
            'project_importid' => request('import_ref'),
            'project_created' => now(),
            'project_timestamp_created' => time(),
            'project_creatorid' => auth()->id(),
            'project_clientid' => $client_id,
            'project_categoryid' => $category_id,
            'project_title' => $row['projecttitle'] ?? '',
            'project_description' => $row['description'] ?? '',
            'project_date_start' => $date_start,
            'project_date_due' => $date_due,
            'project_status' => $status,
            'project_progress' => $progress,
            'project_billing_type' => $billing_type,
            'project_billing_rate' => $row['billingrate'] ?? null,
            'project_billing_estimated_hours' => $row['estimatedhours'] ?? 0,
            'project_billing_costs_estimate' => $row['estimatedcost'] ?? null,
            'project_visibility' => $this->settings->settings_projects_default_visibility ?? 'visible',
            'clientperm_tasks_view' => $this->settings->settings_projects_clientperm_tasks_view,
            'clientperm_tasks_collaborate' => $this->settings->settings_projects_clientperm_tasks_collaborate,
            'clientperm_tasks_create' => $this->settings->settings_projects_clientperm_tasks_create,
            'clientperm_timesheets_view' => $this->settings->settings_projects_clientperm_timesheets_view,
            'clientperm_expenses_view' => $this->settings->settings_projects_clientperm_expenses_view,
            'clientperm_checklists' => $this->settings->settings_projects_clientperm_checklists,
            'assignedperm_tasks_collaborate' => $this->settings->settings_projects_assignedperm_tasks_collaborate,
            'project_custom_field_1' => $row['customfield1'] ?? null,
            'project_custom_field_2' => $row['customfield2'] ?? null,
            'project_custom_field_3' => $row['customfield3'] ?? null,
            'project_custom_field_4' => $row['customfield4'] ?? null,
            'project_custom_field_5' => $row['customfield5'] ?? null,
            'project_custom_field_6' => $row['customfield6'] ?? null,
            'project_custom_field_7' => $row['customfield7'] ?? null,
            'project_custom_field_8' => $row['customfield8'] ?? null,
            'project_custom_field_9' => $row['customfield9'] ?? null,
            'project_custom_field_10' => $row['customfield10'] ?? null,
            'project_custom_field_11' => $row['customfield11'] ?? null,
            'project_custom_field_12' => $row['customfield12'] ?? null,
            'project_custom_field_13' => $row['customfield13'] ?? null,
            'project_custom_field_14' => $row['customfield14'] ?? null,
            'project_custom_field_15' => $row['customfield15'] ?? null,
            'project_custom_field_16' => $row['customfield16'] ?? null,
            'project_custom_field_17' => $row['customfield17'] ?? null,
            'project_custom_field_18' => $row['customfield18'] ?? null,
            'project_custom_field_19' => $row['customfield19'] ?? null,
            'project_custom_field_20' => $row['customfield20'] ?? null,
            'project_custom_field_21' => $row['customfield21'] ?? null,
            'project_custom_field_22' => $row['customfield22'] ?? null,
            'project_custom_field_23' => $row['customfield23'] ?? null,
            'project_custom_field_24' => $row['customfield24'] ?? null,
            'project_custom_field_25' => $row['customfield25'] ?? null,
            'project_custom_field_26' => $row['customfield26'] ?? null,
            'project_custom_field_27' => $row['customfield27'] ?? null,
            'project_custom_field_28' => $row['customfield28'] ?? null,
            'project_custom_field_29' => $row['customfield29'] ?? null,
            'project_custom_field_30' => $row['customfield30'] ?? null,
            'project_custom_field_31' => $row['customfield31'] ?? null,
            'project_custom_field_32' => $row['customfield32'] ?? null,
            'project_custom_field_33' => $row['customfield33'] ?? null,
            'project_custom_field_34' => $row['customfield34'] ?? null,
            'project_custom_field_35' => $row['customfield35'] ?? null,
            'project_custom_field_36' => $row['customfield36'] ?? null,
            'project_custom_field_37' => $row['customfield37'] ?? null,
            'project_custom_field_38' => $row['customfield38'] ?? null,
            'project_custom_field_39' => $row['customfield39'] ?? null,
            'project_custom_field_40' => $row['customfield40'] ?? null,
            'project_custom_field_41' => $row['customfield41'] ?? null,
            'project_custom_field_42' => $row['customfield42'] ?? null,
            'project_custom_field_43' => $row['customfield43'] ?? null,
            'project_custom_field_44' => $row['customfield44'] ?? null,
            'project_custom_field_45' => $row['customfield45'] ?? null,
            'project_custom_field_46' => $row['customfield46'] ?? null,
            'project_custom_field_47' => $row['customfield47'] ?? null,
            'project_custom_field_48' => $row['customfield48'] ?? null,
            'project_custom_field_49' => $row['customfield49'] ?? null,
            'project_custom_field_50' => $row['customfield50'] ?? null,
            'project_custom_field_51' => $row['customfield51'] ?? null,
            'project_custom_field_52' => $row['customfield52'] ?? null,
            'project_custom_field_53' => $row['customfield53'] ?? null,
            'project_custom_field_54' => $row['customfield54'] ?? null,
            'project_custom_field_55' => $row['customfield55'] ?? null,
            'project_custom_field_56' => $row['customfield56'] ?? null,
            'project_custom_field_57' => $row['customfield57'] ?? null,
            'project_custom_field_58' => $row['customfield58'] ?? null,
            'project_custom_field_59' => $row['customfield59'] ?? null,
            'project_custom_field_60' => $row['customfield60'] ?? null,
            'project_custom_field_61' => $row['customfield61'] ?? null,
            'project_custom_field_62' => $row['customfield62'] ?? null,
            'project_custom_field_63' => $row['customfield63'] ?? null,
            'project_custom_field_64' => $row['customfield64'] ?? null,
            'project_custom_field_65' => $row['customfield65'] ?? null,
            'project_custom_field_66' => $row['customfield66'] ?? null,
            'project_custom_field_67' => $row['customfield67'] ?? null,
            'project_custom_field_68' => $row['customfield68'] ?? null,
            'project_custom_field_69' => $row['customfield69'] ?? null,
            'project_custom_field_70' => $row['customfield70'] ?? null,
        ]);
    }

    /**
     * Find client ID by company name (case-insensitive, exact match)
     */
    protected function getClientId($client_name) {
        if (empty($client_name)) {
            return null;
        }

        // Trim whitespace and use case-insensitive exact match
        $client_name = trim($client_name);
        $client = \App\Models\Client::whereRaw('LOWER(TRIM(client_company_name)) = ?', [strtolower($client_name)])->first();
        return $client ? $client->client_id : null;
    }

    /**
     * Find category ID by name (case-insensitive, type=project)
     */
    protected function getCategoryId($category_name) {
        if (empty($category_name)) {
            return 1;
        }

        $category = \App\Models\Category::where('category_type', 'project')
            ->whereRaw('LOWER(category_name) = ?', [strtolower($category_name)])
            ->first();
        return $category ? $category->category_id : 1;
    }

    /**
     * Transform status text to database value
     */
    protected function transformStatus($status) {
        $status_lower = strtolower(trim($status));

        $status_map = [
            'not started' => 'not_started',
            'in progress' => 'in_progress',
            'on hold' => 'on_hold',
            'cancelled' => 'cancelled',
            'completed' => 'completed',
        ];

        return $status_map[$status_lower] ?? 'not_started';
    }

    /**
     * Parse date from various formats to MySQL date format
     * @param mixed $date
     * @return string|null
     */
    protected function parseDate($date) {
        if (empty($date)) {
            return null;
        }

        try {
            // Handle Excel serial date numbers
            if (is_numeric($date)) {
                return \Carbon\Carbon::createFromTimestamp(($date - 25569) * 86400)->format('Y-m-d');
            }

            // Try DD/MM/YYYY format first (e.g., 15/01/2025)
            if (preg_match('#^(\d{1,2})[/\-](\d{1,2})[/\-](\d{4})$#', $date, $matches)) {
                return \Carbon\Carbon::createFromFormat('d/m/Y', $matches[1] . '/' . $matches[2] . '/' . $matches[3])->format('Y-m-d');
            }

            // Try YYYY-MM-DD format (MySQL format)
            if (preg_match('#^(\d{4})[/\-](\d{1,2})[/\-](\d{1,2})$#', $date)) {
                return \Carbon\Carbon::parse($date)->format('Y-m-d');
            }

            // Fallback to Carbon's general parsing for other formats
            return \Carbon\Carbon::parse($date)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    public function rules(): array {
        return [
            'clientname' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!$this->getClientId($value)) {
                        $fail('Client "' . $value . '" not found in database.');
                    }
                },
            ],
            'projecttitle' => ['required'],
        ];
    }

    /**
     * Custom validation messages
     */
    public function customValidationMessages() {
        return [
            'clientname.required' => 'Client name is required.',
            'projecttitle.required' => 'Project title is required.',
        ];
    }

    /**
     * we are ignoring the header and so we will start with row number (2)
     * @return int
     */
    public function startRow(): int {
        return 2;
    }

    /**
     * lets count the total imported rows
     * @return int
     */
    public function getRowCount(): int {
        return $this->rows;
    }

    /**
     * Get assigned users data for post-processing
     * @return array
     */
    public function getAssignedUsers(): array {
        return $this->assignedUsers;
    }
}
