@if($type == 'print')
    <style>
        td, th {
            border-bottom: #0a0a0a 1px solid;
            border-left: #0a0a0a 1px solid;
        }
    </style>
    <table align="center">
        <tbody>
        <tr>
            <td style="border: none;" align="center">
                <h3><span style="border-bottom: double;">{{ $company }}</span></h3>
            </td>
        </tr>
        @if($branch != null)
            <tr>
                <td style="border: none;" align="center">
                    <h3><span style="border-bottom: double;">{{ $branch }}</span></h3>
                </td>
            </tr>
        @endif
        <tr>
            <td style="border: none;" align="center">
                <h3><span style="border-bottom: double;">Chart Of Accounts</span></h3>
            </td>
        </tr>
        </tbody>
    </table>
@endif
<div class="row box box-primary" style="background-color: white">
    <div class="row">
        <div class="col-lg-12 p-5 panel-body pad table-responsive">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th width="20%"><b>Number</b></th>
                    <th width="5%"><b>Type</b></th>
                    <th width="75%"><b>Name</b></th>
                    {{--                    <th style="text-align: right;">Opening Balance (PKR)</th>--}}
                </tr>
                </thead>
                <tbody>
                @if (count($Ledgers) > 0)
                    @foreach ($Ledgers as $id => $data)
                        @if ($id == 0) @continue; @endif
                        <tr>
                            <td>
                                @if($id < 0)
                                    <span style="color: maroon;font-weight: bold">{!! $data['number'] !!} </span>
                                @else
                                    <span style="color: darkblue;">{!! $data['number'] !!} </span>
                                @endif
                            </td>
                            <td>@if ($id < 0) <span style="color: maroon;font-weight: bold">Group </span> @else
                                    <span style="color: darkblue;"> Ledger </span> @endif</td>
                            <td>

                                @if ($id < 0)
                                    <span style="color: maroon;font-weight: bold">{!! $data['name'] !!} </span>
                                @else
                                    {{--@if(Gate::check('ledgers_edit'))--}}
                                    <span style="color: darkblue;">
                                        @if($type == 'web')
                                            <a href="{{ route('admin.ledger.edit',[$id]) }}"> <?php echo $data['name'] ?> </a>
                                        @else
                                            <?php echo $data['name'] ?>
                                        @endif
                                    </span>
                                    {{--@endif--}}
                                @endif
                                {{--{{ $data['name'] }}--}}
                            </td>
                            {{--                            <td align="right">@if ($id < 0) N/A @else {{ $Currency::curreny_format($data['opening_balance']) }} @endif</td>--}}
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td align="center" colspan="3">No entries in a table</td>
                    </tr>
                @endif
                </tbody>
            </table>
        </div>
    </div>
</div>
