/**
 * Created by jsj on 15/8/29.
 */
;(function(ns){
    var ConditionEditor = {};
    var itemIndex = 0;
    var num = 0;
    var defaultConfig = {
        containerId : '',
        levels:{},
        categories:{},
        andOr: [{"id":1,"text":'AND'},{"id":2,"text":'OR'}],
        relations:[{"id":1,"text":"包含"},{"id":2,"text":"不包含"}],
        keys: [{"id":1,"text":"告警类型"},{"id":2,"text":"告警级别"},{"id":3,"text":"关键字"}],
        sets:[]    //已选数据
    };
    var configs = defaultConfig;
    //下拉框模版
    var itemTemplate = '<select name="{NAME}" id="{ID}" class="{CLASS}">{SELECTED}</select>';

    var init = function(c){
        configs = $.extend(configs,c);
        renderButton();

        var sets = configs["sets"];
        var length = sets.length;
        for(var i=0; i<length;i++){
            renderItem(sets[i]);
        }
        if(length ==0){
            renderItem();
        }
        $(".condition-contain").select2({
            data: configs["relations"],
            placeholder: "请选择"
        });
        $(".condition-key").select2({
            data: configs["keys"],
            placeholder: "请选择"
        });
        var valSelects = $(".condition-val");
        $.each(valSelects,function(k,item){
            if($(item).is("select")){
                $(item).select2({
                    data: configs["categories"],
                    placeholder: "请选择"
                })
            }
        })
        /*
        $(".condition-val").select2({
            data: configs["categories"],
            placeholder: "请选择"
        });*/
        bindEvent();
    }

    var renderItem = function(data){
        itemIndex ++;
        var html = [];
        html.push('<div class="form-group" _index="'+itemIndex+'">');
        html.push(renderSelect("condition_contain",data,'condition-contain'));
        html.push(renderSelect("condition_key",data,'condition-key'));   //LEVEL | CATEGORY
        html.push(renderSelect("condition_val",data,'condition-val'));
        //删除按钮或图标
        if(itemIndex!=1){
            html.push('<span class="glyphicon glyphicon-trash delete" aria-hidden="true"></span>')
        }
        html.push('</div>');
        var container = html.join("\n",html);
        $('#'+configs['containerId']).append(container);
        return itemIndex;
    }

    var renderButton = function(){
        var html = [];
        html.push('<div class="">');
        html.push('<button class="btn btn-default" type="button" id="add">添加新条件</button>');
        html.push('</div>');

        $('#'+configs['containerId']).append(html.join("\n"));
    }

    function bindEvent(){
        var changeHandle = function(){
            var _val = $(this).val();
            var $parent = $(this).parent('.form-group');
            //console.log(_val);return;
            var relationSelect = $parent.find('.condition-val');
            if(relationSelect.is("select")){
                relationSelect.select2('destroy');
            }
            relationSelect.remove();
            switch (_val){
                case '1':
                    var select = renderSelect("condition_val",'','condition-val');
                    if($parent.find('.delete').length>0){
                        $parent.find('.delete').before(select);
                    }else{
                        $parent.append(select);
                    }
                    $parent.find('.condition-val').select2({
                        data: configs["categories"]
                    });
                    break;
                case '2':
                    var select = renderSelect("condition_val",'','condition-val');
                    if($parent.find('.delete').length>0){
                        $parent.find('.delete').before(select);
                    }else{
                        $parent.append(select);
                    }                    $parent.find('.condition-val').select2({
                        data: configs["levels"]
                    });

                    break;
                case '3':
                    if($parent.find('.delete').length>0){
                        $parent.find('.delete').before('<input type="text" class="condition-val form-control" value="" style="width: 200px;">');
                    }else{
                        $parent.append('<input type="text" class="condition-val form-control" value="" style="width:200px;">');
                    }
                    break;
            }
        };
        $('.condition-key').on("change",changeHandle);
        $('.delete').on('click',function(){
            $(this).parent(".form-group").remove();
        })
        $('#add').on('click',function(){
            var index = renderItem();
            $item = $('.form-group[_index='+index+']');
            $item.find(".condition-contain").select2({
                data: configs["relations"],
                placeholder: "请选择"
            });
            $item.find(".condition-key").select2({
                data: configs["keys"],
                placeholder: "请选择"
            });
            $item.find(".condition-val").select2({
                data: configs["categories"],
                placeholder: "请选择"
            });
            $item.find('.delete').on('click',function(){
                $(this).parent(".form-group").remove();
            })
            $item.find(".condition-key").on('change',changeHandle)
        });
    }

    var renderSelect = function(name,selected,className,id){
        if(!id){
            id= getUniqueId();
        }
        if(!className){
            className = 'condition-selected';
        }
        var tpl = itemTemplate;
        if(selected){
            var text = '';
            var val = '';
            switch(name){
                case 'condition_contain':
                    val = selected["contain"];
                    text = getTextByVal(configs["relations"],val);
                    break;
                case 'condition_key':
                    val = selected["key"];
                    text = getTextByVal(configs["keys"],val);
                    break;
                case 'condition_val':
                    if(selected["key"] ==1){
                        val = selected["val"];
                        text = getTextByVal(configs["categories"],val);
                    }else if(selected["key"] == 2){
                        val = selected["val"];
                        text = getTextByVal(configs["levels"],val);
                    }else{
                        return  '<input type="text" class="condition-val form-control" value="'+selected['val']+'" style="width:200px;">';
                    }
            }

            tpl = tpl.replace(/\{SELECTED\}/,'<option value="'+val+'" selected="selected" > '+text+' </option>')
        }else{
            tpl = tpl.replace(/\{SELECTED\}/,' ')
        }
        return tpl.replace(/\{NAME\}/,name)
            .replace(/\{ID\}/,id)
            .replace(/\{CLASS\}/,className);

    }

    var getTextByVal = function(data,val){
        var text= '';
        $.each(data,function(k,item){
            if(item["id"] == val){
                text = item["text"];
                return false;
            }
        })
        return text;
    }
    var getUniqueId = function(){
        num++;
        return 'select2-'+num;
    }
    function exportFun(key, value) {
        ConditionEditor[key] = value;
    }

    /**
     * 获取条件结果
     */
    function getConditions(){
        var items = $('#'+configs["containerId"]).find('.form-group');
        var results = [];
        $.each(items,function(k,item){
            var obj = {};
            obj['contain'] = $(item).find('.condition-contain').val();
            obj['key'] = $(item).find('.condition-key').val();
            obj['val'] = $(item).find('.condition-val').val();
            results.push(obj);
        })
        return results;
    }

    exportFun('init',init);
    exportFun('getConditions',getConditions);

    window[ns] = ConditionEditor
})('ConEditor');