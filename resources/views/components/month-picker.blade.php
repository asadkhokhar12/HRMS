
<style>
  
        .input-icons i {
            position: absolute;
        }
          
        .input-icons {
            width: 100%;
            margin-bottom: 10px;
        }
          
        .icon {
            padding: 10px;
            color: rgb(165, 165, 165);
            min-width: 50px;
            text-align: center;
            position: absolute;
            top: 90px;
            left: 27.5%;

        }
          
        .input-field {
            width: 100%;
            padding: 10px;
            text-align: center;
        }
        .month_picker{
            width: 300px;
            position: relative;
        }
</style>
<div>
    <!-- No surplus words or unnecessary actions. - Marcus Aurelius -->
   
    <div class="input-icons">
        <input class=" form-control month_picker" id="month_picker"
               placeholder="{{ _trans('common.Select Month') }}"
               autocomplete="off"/>
               <i class="far fa-calendar-alt icon"></i>
       
    </div>   
      
</div>
@include('backend.partials.script')
<script>
     $('#month_picker').datetimepicker({
        format: 'MM y',
        viewMode: 'months',
      });
</script>