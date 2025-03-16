@inject('request', 'Illuminate\Http\Request')
<style type="text/css">
    table {
        border-collapse: collapse;
        width: 100%;
    }

    td, th {
        padding: 8px;
    }

    tr:nth-child(even) {
    }

    .tr {
        border: 1px solid;
    }

    td {
        text-align: center !important;
    }
</style>
<div class="panel-body pad table-responsive">

    <table align="center">
        <tbody>
        <tr>
            <td align="center">
                <h3><span style="border-bottom: double;">{{ $dataArray['session'] }}</span></h3>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h3><span style="border-bottom: double;">{{ $dataArray['company'] }}</span></h3>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h3><span style="border-bottom: double;">{{ $dataArray['branch'] }}</span></h3>
            </td>
        </tr>
        <tr>
            <td align="center">
                <h3><span style="border-bottom: double;">Chronic Report</span></h3>
            </td>
        </tr>
        <tr>
            <td align="center">
                <span style="border-bottom: dot-dash;">
                    @if ($dataArray['board'] != null)
                        <span style="font-weight: bold">Board:</span> {{ $dataArray['board'] }}
                    @endif @if ($dataArray['program'] != null)
                        <span style="font-weight: bold">Program:</span> {{ $dataArray['program'] }}
                    @endif @if ($dataArray['class'] != null)
                        <span style="font-weight: bold">Class:</span> {{ $dataArray['class'] }}
                    @endif @if ($dataArray['intake'] != null)
                        <span style="font-weight: bold">Intake:</span> {{ $dataArray['intake'] }}
                    @endif @if ($dataArray['section'] != null)
                        <span style="font-weight: bold">Section:</span> {{ $dataArray['section'] }}
                    @endif
                </span>
            </td>
        </tr>
        </tbody>
    </table>
    <div class="clear clearfix"></div>
    <!-- Liabilities and Assets -->

    <div class="col-md-12">
        <table class="table" style="width:100%;">
            <thead>
            <tr>
                <th>Admission No</th>
                <th>Student Name</th>
                <th>Current Month Defaulter</th>
                <th>Previous Defaulter</th>
            </tr>
            </thead>
            @php
                $htmlData = "";
                $k = 1;
                $existing_branch_name = "";
                $existing_class = "";
                $new_class = "";
                $total_students = 0;
            @endphp
            <tbody>
            <?php
            $total_students = 0; // Initialize the variable to store total students
            $existing_branch_name = ''; // Initialize the variable to store existing branch name
            $existing_class = ''; // Initialize the variable to store existing class name

            foreach ($array_list as $item) {
            $branch_name = $item['branch_name'];
            if ($existing_branch_name == $branch_name) {
            $new_class = $item['class_name'];
            if ($existing_class == $new_class) {
            $total_students++;
            ?>
            <tr>
                <td>{{ $item['reg_no'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td style="color:white;background-color:#ef4545;">{{ $item['term'] }}</td>
                <td style="color:white;background-color:#ef4545;">{{ $item['shift'] }}</td>
            </tr>
            <?php
            $k++;
            } else {
            ?>
            <tr style="text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;">
                <td>Total Students:</td>
                <td colspan="5">{{ $total_students }}</td>
            </tr>
            <?php
            $total_students = 0;
            $total_students++;
            $existing_class = $item['class_name'];
            ?>
            <tr style="background: #9506e2;color: black;text-align: left;font-weight: 700;">
                <td colspan="6">{{ $item['class_name'] }}</td>
            </tr>
            <tr>
                <td>{{ $item['reg_no'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td style="color:white;background-color:#ef4545;">{{ $item['term'] }}</td>
                <td style="color:white;background-color:#ef4545;">{{ $item['shift'] }}</td>
            </tr>
            <?php
            $k++;
            }
            } else {
            if ($k > 1) {
            ?>
            <tr style="text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;">
                <td>Total Students:</td>
                <td colspan="5">{{ $total_students }}</td>
            </tr>
            <?php
            $total_students = 0;
            $total_students++;
            }

            $existing_branch_name = $item['branch_name'];
            $existing_class = $item['class_name'];
            ?>
            <tr style="background: #9506e2;color: black;text-align: left;font-weight: 700;">
                <td colspan="6">{{ $item['branch_name'] }}</td>
            </tr>

            <tr style="background: #9506e2;color: black;text-align: left;font-weight: 700;">
                <td colspan="6">{{ $item['class_name'] }}</td>
            </tr>

            <tr>
                <td>{{ $item['reg_no'] }}</td>
                <td>{{ $item['name'] }}</td>
                <td style="color:white;background-color:#ef4545;">{{ $item['term'] }}</td>
                <td style="color:white;background-color:#ef4545;">{{ $item['shift'] }}</td>
            </tr>
            <?php
            $k++;
            }
            }
            ?>
            <tr style="text-align: center;background-color: #bbb1b1;color: black;font-weight: 700;">
                <td>Total Students:</td>
                <td colspan="5">{{ $total_students }}</td>
            </tr>

            </tbody>
        </table>
    </div>
</div>
