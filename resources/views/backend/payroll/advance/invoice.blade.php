@extends('backend.layouts.app')
@section('title', @$data['title'])
@section('content')

    <div class="content-wrapper">

        <div class="container-fluid invoice-container">
            <div id="invoice">
      <!-- Header -->
      <header>
        <div class="row align-items-center">
            <div class="col-sm-7  text-sm-start mb-3 mb-sm-0">
                <img id="logo" src="{{url('/') }}/assets/logo-dark.png" title="Koice" alt="Koice">
            </div>
            <div class="col-sm-5 text-sm-end">
                <h4 class="text-7 mb-0">{{ _trans('payroll.Invoice') }}</h4>
            </div>
        </div>
        <hr>
    </header>

    <!-- Main Content -->
    <main>
        <div class="row">
            <div class="col-sm-6"><strong>{{ _trans('payroll.Date:') }}</strong> {{ _trans('payroll.05/12/2020') }}</div>
            <div class="col-sm-6 text-sm-end"> <strong>{{ _trans('payroll.Invoice No:') }}</strong> {{ _trans('payroll.16835') }}</div>

        </div>
        <hr>
        <div class="row">
            <div class="col-sm-6 text-sm-end order-sm-1"> <strong>{{ _trans('payroll.Pay To:') }}</strong>
                <address>
                    {{ _trans('payroll.Koice Inc') }}<br>
                    {{ _trans('payroll.2705 N. Enterprise St') }}<br>
                    {{ _trans('payroll.Orange, CA 92865') }}<br>
                    {{ _trans('payroll.contact@koiceinc.com') }}
                </address>
            </div>
            <div class="col-sm-6 order-sm-0"> <strong>{{ _trans('payroll.Invoiced To:') }}</strong>
                <address>
                    {{ _trans('payroll.Smith Rhodes') }}<br>
                    {{ _trans('payroll.15 Hodges Mews, High Wycombe') }}<br>
                    {{ _trans('payroll.HP12 3JL') }}<br>
                    {{ _trans('payroll.United Kingdom') }}
                </address>
            </div>
        </div>

        <div class="card box-shadow-none border-none">
            <div class="card-body p-0">
                <div class=" box-shadow-none">
                    <table class="table mb-0">
                        <thead class="card-header-invoice header-color">
                            <tr>
                                <td class="w-150"><strong> {{ _trans('payroll.Advance Type') }}</strong></td>
                                <td class="w-150"><strong>{{ _trans('payroll.Request Amount') }}</strong></td>
                                <td class="text-center w-150"><strong>{{ _trans('payroll.Approved Amount') }}</strong>
                                </td>
                                <td class="text-center w-150"><strong>{{ _trans('payroll.Returned Amount') }}</strong>
                                </td>
                                <td class="text-end w-150"><strong>{{ _trans('payroll.Due Amount') }}</strong></td>
                                <td class="text-end w-150"><strong>{{ _trans('payroll.Request Month') }}</strong></td>
                                <td class="text-end w-150"><strong>{{ _trans('payroll.Recover Mode') }}</strong></td>
                                <td class="text-end w-150"><strong>{{ _trans('payroll.Installment Amount') }}</strong>
                                </td>
                                <td class="text-end w-150"><strong>{{ _trans('payroll.Status') }}</strong></td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ @$data['advance']->advance_type->name }} </td>
                                <td>{{ currency_format(@$data['advance']->request_amount ?? 0) }} </td>
                                <td class=" text-center">{{ currency_format(@$data['advance']->amount ?? 0) }}
                                </td>
                                <td class="text-center">
                                    {{ currency_format(@$data['advance']->paid_amount ?? 0) }} </td>
                                <td class=" text-end">{{ currency_format(@$data['advance']->due_amount ?? 0) }}
                                </td>
                                <td class=" text-end">{{ date('F Y', strtotime(@$data['advance']->date)) }}
                                </td>
                                <td class=" text-end">
                                    @if (@$data['advance']->recovery_mode)
                                        {{ _trans('payroll.Installment') }}
                                    @else
                                        {{ _trans('payroll.One Time') }}
                                    @endif
                                </td>
                                <td class=" text-end">
                                    {{ currency_format(@$data['advance']->installment_amount ?? 0) }} </td>
                                <td class=" text-end">{{ @$data['advance']->remarks }} </td>
                            </tr>

                        </tbody>
                        <tfoot class="card-footer-invoice border-none">
                            <tr>
                                <td class="text-end" colspan="8"><strong>{{ _trans('payroll.Sub Total:') }}</strong></td>
                                <td class="text-end" colspan="8">{{ _trans('payroll.$2150.00') }}</td>
                            </tr>
                            <tr>
                                <td class="text-end" colspan="8"><strong>{{ _trans('payroll.Tax:') }}</strong></td>
                                <td class="text-end" colspan="8">{{ _trans('payroll.$215.00') }}</td>
                            </tr>
                            <tr>
                                <td class="text-end border-bottom-0" colspan="8"><strong>{{ _trans('payroll.Total:') }}</strong></td>
                                <td class="text-end border-bottom-0" colspan="8">{{ _trans('payroll.$2365.00') }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
    </main>
            </div>
            <!-- Footer -->
            <footer class="text-center mt-4">
                <p class="text-1"><strong>{{ _trans('payroll.NOTE :') }}</strong> {{ _trans('payroll.This is computer generated receipt and does not require physical signature.') }}</p>
                <div class="btn-group btn-group-sm d-print-none"> <a href="javascript:window.print()"
                        class="btn btn-light border text-black-50 shadow-none"><i class="fa fa-print"></i> {{ _trans('payroll.Print') }}</a> <a
                        href="javascript:void(0)" class="btn btn-light border text-black-50 shadow-none" id="downloadPDF"><i class="fa fa-download"></i>
                        {{ _trans('payroll.Download') }}</a> </div>
            </footer>
        </div>
    </div>
    @endsection
