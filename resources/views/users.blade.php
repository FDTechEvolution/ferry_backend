@extends('layouts.default')

@section('content')
    <header>
        <h1 class="h4">Users</h1>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb small">
            <li class="breadcrumb-item text-muted active" aria-current="page">You've got 2 new sales today</li>
            </ol>
        </nav>
    </header>

    <div class="row">
        <div class="col-11">
            <table class="table-datatable table table-bordered table-hover table-striped"
                data-lng-empty="No data available in table"
                data-lng-page-info="Showing _START_ to _END_ of _TOTAL_ entries"
                data-lng-filtered="(filtered from _MAX_ total entries)"
                data-lng-loading="Loading..."
                data-lng-processing="Processing..."
                data-lng-search="Search..."
                data-lng-norecords="No matching records found"
                data-lng-sort-ascending=": activate to sort column ascending"
                data-lng-sort-descending=": activate to sort column descending"

                data-main-search="true"
                data-column-search="false"
                data-row-reorder="false"
                data-col-reorder="true"
                data-responsive="true"
                data-header-fixed="true"
                data-select-onclick="true"
                data-enable-paging="true"
                data-enable-col-sorting="true"
                data-autofill="false"
                data-group="false"
                data-items-per-page="30"

                data-enable-column-visibility="true"
                data-lng-column-visibility="Column Visibility"

                data-enable-export="true"
                data-lng-export="<i class='fi fi-squared-dots fs-5 lh-1'></i>"
                data-lng-csv="CSV"
                data-lng-pdf="PDF"
                data-lng-xls="XLS"
                data-lng-copy="Copy"
                data-lng-print="Print"
                data-lng-all="All"
                data-export-pdf-disable-mobile="true"
                data-export='["csv", "pdf", "xls"]'
                data-options='["copy", "print"]'

                data-custom-config='{}'>
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Doris Wilder</td>
                        <td>Sales Assistant</td>
                        <td>Sidney</td>
                        <td>23</td>
                        <td>2010/09/20</td>
                        <td>$85,600</td>
                    </tr>
                    <tr>
                        <td>Angelica Ramos</td>
                        <td>Chief Executive Officer (CEO)</td>
                        <td>London</td>
                        <td>47</td>
                        <td>2009/10/09</td>
                        <td>$1,200,000</td>
                    </tr>
                    <tr>
                        <td>Gavin Joyce</td>
                        <td>Developer</td>
                        <td>Edinburgh</td>
                        <td>42</td>
                        <td>2010/12/22</td>
                        <td>$92,575</td>
                    </tr>
                    <tr>
                        <td>Hermione Butler</td>
                        <td>Regional Director</td>
                        <td>London</td>
                        <td>47</td>
                        <td>2011/03/21</td>
                        <td>$356,250</td>
                    </tr>
                    <tr>
                        <td>Lael Greer</td>
                        <td>Systems Administrator</td>
                        <td>London</td>
                        <td>21</td>
                        <td>2009/02/27</td>
                        <td>$103,500</td>
                    </tr>
                    <tr>
                        <td>Jonas Alexander</td>
                        <td>Developer</td>
                        <td>San Francisco</td>
                        <td>30</td>
                        <td>2010/07/14</td>
                        <td>$86,500</td>
                    </tr>
                    <tr>
                        <td>Shad Decker</td>
                        <td>Regional Director</td>
                        <td>Edinburgh</td>
                        <td>51</td>
                        <td>2008/11/13</td>
                        <td>$183,000</td>
                    </tr>
                    <tr>
                        <td>Michael Bruce</td>
                        <td>Javascript Developer</td>
                        <td>Singapore</td>
                        <td>29</td>
                        <td>2011/06/27</td>
                        <td>$183,000</td>
                    </tr>
                    <tr>
                        <td>Donna Snider</td>
                        <td>Customer Support</td>
                        <td>New York</td>
                        <td>27</td>
                        <td>2011/01/25</td>
                        <td>$112,000</td>
                    </tr>
                </tbody>
                <tfoot>
                    <tr>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Office</th>
                        <th>Age</th>
                        <th>Start date</th>
                        <th>Salary</th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
@stop