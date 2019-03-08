@extends('layout.app')
@section('content')


                    <div class="card">
                        <div class="card-header">
                            <div class="card-title">
                                <div class="title">Theming</div>
                            </div>
                        </div>
                        <div class="card-body">
                            <p>Choose your navbar and sidebar color pattern. Default or Inverse Color.</p>
                            <div class="sub-title">Navbar</div>
                            <div>
                                <div class="radio3 radio-check radio-inline">
                                    <input type="radio" id="radio1" name="radio-navbar" value="default" checked="">
                                    <label for="radio1">
                                        Default
                                    </label>
                                </div>
                                <div class="radio3 radio-check radio-inline">
                                    <input type="radio" id="radio2" name="radio-navbar" value="inverse">
                                    <label for="radio2">
                                        Inverse
                                    </label>
                                </div>
                            </div>
                            <div class="sub-title">Sidebar</div>
                            <div>
                                <div class="radio3 radio-check radio-inline">
                                    <input type="radio" id="radio3" name="radio-sidebar" value="default">
                                    <label for="radio3">
                                        Default
                                    </label>
                                </div>
                                <div class="radio3 radio-check radio-inline">
                                    <input type="radio" id="radio4" name="radio-sidebar" value="inverse" checked="">
                                    <label for="radio4">
                                        Inverse
                                    </label>
                                </div>
                            </div>
                            <div class="sub-title">Color Scheme</div>
                            <div>
                                <div class="radio3 radio-check radio-inline">
                                    <input type="radio" id="radio-blue" name="radio-color" value="blue" checked="">
                                    <label for="radio-blue">
                                        Blue (Default)
                                    </label>
                                </div>
                                <div class="radio3 radio-check radio-success radio-inline">
                                    <input type="radio" id="radio-green" name="radio-color" value="green">
                                    <label for="radio-green">
                                        Green
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


@include('layout._moreDel');{{--批量删除--}}
@stop

