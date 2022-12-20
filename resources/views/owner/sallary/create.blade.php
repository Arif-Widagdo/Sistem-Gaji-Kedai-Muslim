<x-app-dashboard title="Daftar Gaji">
    <x-slot name="header">
        Daftar Gaji
    </x-slot>
    <x-slot name="links">
        <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item active">{{ __('........') }}</li>
        </ol>
    </x-slot>




    <div class="row">
        <div class="col-12">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
                <!-- title row -->
                <div class="row">
                    <div class="col-12">
                        <h4>
                            <i class="fas fa-globe"></i> KedaiMuslim.id.
                            <small class="float-right">Date: {{ now()->format('j M Y') }}</small>
                        </h4>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- info row -->
                <div class="row invoice-info">
                    <div class="col-sm-6 invoice-col">
                        From
                        <address>
                            <strong>Kedai Muslim</strong><br>
                            Sidomulyo, South Lampung Regency<br>
                            Lampung 35353<br>
                            (+62) 812-7920-2340
                        </address>
                    </div>
                    <!-- /.col -->
                    <div class="col-sm-6 invoice-col">
                        To
                        <address>
                            <strong>{{ $user->name }}</strong><br>
                            Phone: {{ $user->telp }}<br>
                            Email: {{ $user->email }}
                            <p class="col-8 p-0 m-0">{{ $user->address }}</p>
                          </address>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- Table row -->
                <div class="row">
                    <div class="col-12 table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No.</th>
                                    <th>Kategori Produk</th>
                                    <th>Kuantitas</th>
                                    <th>Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>Koko</td>
                                    <td>50</td>
                                    <td>Rp. 50.000,00</td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Hijab Syari</td>
                                    <td>70</td>
                                    <td>Rp. 35.000,00</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <div class="row">
                    <div class="col-6">
                        <p class="lead">Amount Due 2/22/2014</p>
                        <div>
                            <div class="d-flex">
                                <b class="mr-2">Total:</b>
                                <p>Rp. 85.000,00</p>
                            </div>
                            <div>
                                <form action="" width="100%">
                                    <select name="" id="" style="width: 100%;">
                                        <option selected>Pilih Status</option>
                                        <option value="">Lunas</option>
                                        <option value="">Tidak Lunas</option>
                                    </select>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- /.row -->

                <!-- this row will not appear when printing -->
                <div class="row no-print">
                    <div class="col-12">
                       
                        <button type="button" class="btn btn-success float-right"><i class="far fa-credit-card"></i>
                            Submit
                        </button>
                        <a href="invoice-print.html" rel="noopener" target="_blank" class="btn btn-primary float-right"  style="margin-right: 5px;">
                            <i class="fas fa-print"></i> Print
                        </a>
                    </div>
                </div>
            </div>
            <!-- /.invoice -->
        </div><!-- /.col -->
    </div><!-- /.row -->








</x-app-dashboard>