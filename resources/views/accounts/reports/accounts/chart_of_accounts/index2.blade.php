@extends('layouts.app')
@section('stylesheet')

@stop
@section('content')

    <div class="row box box-primary" style="background-color: white">
        <div class="row">
            <div class="col-lg-12 mt-3">
                <form> @csrf
                    <button type="submit" class="btn btn-sm btn-success" style="float: right"
                            formaction="chart-of-accounts/pdf?type=print"
                            formmethod="post"><i class="fa fa-print"></i>PDF
                    </button>
                </form>
            </div>
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

                                        @php $margin=0;
                                           if ($data['level'] == 1) {
                                        $margin = 0;
                                        $font = "";
                                        } else {
                                        $margin = $data['level'] * 30;
                                        $margin = $margin + 20;
                                        $font = 900 - 100 * $data['level'];
                                        }
                                        @endphp



                                        <span
                                            style="color: maroon;font-weight: bold;">{!! $data['number'] !!} </span>
                                    @else
                                        <span style="color: darkblue;">{!! $data['number'] !!} </span>
                                    @endif
                                </td>
                                <td>@if ($id < 0) <span style="color: maroon;font-weight: bold">Group </span> @else
                                        <span style="color: darkblue;"> Ledger </span> @endif</td>
                                <td>

                                    @if ($id < 0)
                                         <span style="color: maroon;font-weight: bold;margin-left: {!! $margin !!}px">Level- {!! $data['level'] !!} - {!! $data['name'] !!} </span>
                                    @else
                                        {{--@if(Gate::check('ledgers_edit'))--}}
                                        <span style="color: darkblue;">
                                        <a href="{{ route('admin.ledger.edit',[$id]) }}"> <?php echo $data['name'] ?> </a>
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
                            <td colspan="3">@lang('global.app_no_entries_in_table')</td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop

@section('javascript')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"
            integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g=="
            crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $("#pdf_button").click(function () {

            $.ajax({
                url: '{{ route("admin.chart-of-accounts.pdf") }}',
                type: 'get',
                data: {},
                success: function (data) {
                    return 0;
                }
            });

        });
    </script>
@stop
