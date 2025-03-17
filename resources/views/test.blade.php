@extends('app.master')

@section('konten')
<div class="content-body">
    <select name="" id="" class="select2" data-placeholder="Pilih Opsi">
        <option value=""></option>
        <option value="1">1</option>
        <option value="2">2</option>
        <option value="3">3</option>
        <option value="4">4</option>
        <option value="5">5</option>
    </select>
</div>
@endsection

@section('script')
<script>
    $(document).ready(() => {
        $('.select2').select2({width:'100%'});
    })
</script>

@endsection
