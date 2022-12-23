<x-mail-layout>
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="padding: 24px 0;">
        <tr>
            <td align="center" style="background-color: #EDF2F7;" bgcolor="#EDF2F7">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:680px;">
                    <tr>
                        <td align="center" style="padding: 35px 35px 20px 35px; background-color: #ffffff; border-radius:10px;" bgcolor="#ffffff">
                            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width:680px;">
                                {{-- Logo --}}
                                <tr>
                                    <td align="left">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="50%">
                                                    <div style="display:flex; vertical-align:top; ">
                                                        <img src="{{ $message->embed('dist/img/logos/purpleLogo.png') }}" alt="" width="90" height="90" class="mr-2">
                                                        <h3 class="page-header"
                                                            style="font-family: 'Kalam', cursive; font-size: 20px; font-weight: 700 !important; line-height:25px; ">
                                                            Kedai Muslim <br>
                                                            Collection
                                                        </h3>
                                                    </div>
                                                </td>
                                                <td width="50%" align="right">
                                                    <h3 class="page-header" style="font-family: 'Kalam', cursive; font-weight: 700 !important; line-height:25px; ">
                                                        {{ __('Salary in') }} {{ $isi_email['sallaryMonth'] }}
                                                    </h3>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                {{-- Header --}}
                                <tr>
                                    <td align="center" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="35%" align="left">
                                                    {{ __('From') }}
                                                </td>
                                                <td width="35%" align="left">
                                                    {{ __('To') }}
                                                </td>
                                                <td width="30%" align="left">
                                                    {{ __('Date') }}: <strong>{{ now()->format('d, F Y') }}</strong>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td width="35%">
                                                    <address>
                                                        <strong>Kedai Muslim</strong><br>
                                                    </address>
                                                </td>
                                                <td width="35%">
                                                    <address>
                                                        <strong>{{ $isi_email['user']->email }}</strong><br>
                                                    </address>
                                                </td>
                                                <td width="30%"></td>
                                            </tr>
                                            <tr>
                                                <td width="35%">
                                                    <address>
                                                        Sidomulyo, South Lampung Regency<br>
                                                        Lampung 35353<br>
                                                        (+62) 812-7920-2340
                                                    </address>
                                                </td>
                                                <td width="35%">
                                                    <address>
                                                        @if($isi_email['user']->telp)
                                                            {{ $isi_email['user']->telp }}<br>
                                                        @endif
                                                        {{ $isi_email['user']->address }}
                                                    </address>
                                                </td>
                                                <td width="30%"></td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                {{-- /Header --}}
                                {{-- Body --}}
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <th width="10%" align="left" bgcolor="#EDF2F7" style="font-family: 'Kalam', cursive; font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px;">
                                                    No.
                                                </th>
                                                <th width="30%" align="left" bgcolor="#EDF2F7" style="font-family: 'Kalam', cursive; font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px;">
                                                    {{ __('Product Category') }}
                                                </th>
                                                <th width="30%" align="left" bgcolor="#EDF2F7" style="font-family: 'Kalam', cursive; font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px;">
                                                    {{ __('Quantities') }}
                                                </th>
                                                <th width="30%" align="left" bgcolor="#EDF2F7" style="font-family: 'Kalam', cursive; font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px;">
                                                    {{ __('Subtotal') }}
                                                </th>
                                            </tr>
                                            @if($isi_email['products'])
                                                @if($isi_email['products']->count() > 0)
                                                    @foreach ($isi_email['products'] as $key => $product)
                                                    <tr>
                                                        <td width="10%" align="left" style="font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                            {{ $loop->iteration }}
                                                        </td>
                                                        @foreach ($isi_email['categories']->where('id', $key) as $category)
                                                        <td width="30%" align="left" style="font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                            {{ $category->name }}
                                                        </td>
                                                        @endforeach
                                                    
                                                        <td width="30%" align="left" style="font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                            {{ $product->sum('quantity') }} Item
                                                        </td>
                                                        @foreach ($isi_email['services']->where('id_category', $category->id) as $service)
                                                        <td width="30%" align="left" style="font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                                            Rp. {{ number_format($service->sallary*$product->sum('quantity'),2,',','.') }}
                                                        </td>
                                                        @endforeach
                                                    </tr>
                                                    @endforeach
                                                @else
                                                <tr>
                                                    <td colspan="4" class="text-center" class="text-center" style="font-family: 'Kalam', cursive;">{{ __('Data is Empty') }} {{ __('You Need to Calm Down') }}</td>
                                                </tr>
                                                @endif
                                            @endif
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td align="left" style="padding-top: 20px;">
                                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                            <tr>
                                                <td width="40%" align="left" style="font-family: 'Kalam', cursive; font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px; border-top: 3px solid #EDF2F7; border-bottom: 3px solid #EDF2F7;">
                                                    TOTAL
                                                </td>
                                                <td width="30%"  align="left" style="font-family: 'Kalam', cursive; font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px; border-top: 3px solid #EDF2F7; border-bottom: 3px solid #EDF2F7;">
                                                    {{ $isi_email['quantity'] }} Item
                                                </td>
                                                <td width="30%" align="left" style="font-size: 16px; font-weight: 700; line-height: 24px; padding: 10px; border-top: 3px solid #EDF2F7; border-bottom: 3px solid #EDF2F7;">
                                                    Rp. {{ number_format($isi_email['totalCost'],2,',','.') }}
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                {{-- /Body --}}
                            </table>
                        </td>
                    </tr>
                    <tr align="center">
                        <td style="padding: 28px 0;">
                            &copy; {{ date('Y') }} {{ config('app.name') }}. @lang('All rights reserved.')
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</x-mail-layout>