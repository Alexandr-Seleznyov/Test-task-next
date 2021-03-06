$(document).ready(function() {

    var DragManager = new function() {

        /**
         *  Основа скрипта - https://learn.javascript.ru/drag-and-drop-objects
         * {
         *   elem - элемент, на котором была зажата мышь
         *   avatar - аватар
         *   downX/downY - координаты, на которых был mousedown
         *   shiftX/shiftY - относительный сдвиг курсора от угла элемента
         * }
         */
        var dragObject = {};

        var self = this;

        function onMouseDown(e) {

            if (e.which != 1) return;

            var elem = e.target.closest('.panel-heading');
            if (!elem) return;

            dragObject.elem = elem;

            // запомним, что элемент нажат на текущих координатах pageX/pageY
            dragObject.downX = e.pageX;
            dragObject.downY = e.pageY;

            return false;
        }

        function onMouseMove(e) {
            if (!dragObject.elem) return; // элемент не зажат

            if (!dragObject.avatar) { // если перенос не начат...
                var moveX = e.pageX - dragObject.downX;
                var moveY = e.pageY - dragObject.downY;

                // если мышь передвинулась в нажатом состоянии недостаточно далеко
                if (Math.abs(moveX) < 3 && Math.abs(moveY) < 3) {
                    return;
                }

                // начинаем перенос
                dragObject.avatar = createAvatar(e); // создать аватар
                if (!dragObject.avatar) { // отмена переноса, нельзя "захватить" за эту часть элемента
                    dragObject = {};
                    return;
                }

                // аватар создан успешно
                // создать вспомогательные свойства shiftX/shiftY
                var coords = getCoords(dragObject.avatar);
                dragObject.shiftX = dragObject.downX - coords.left;
                dragObject.shiftY = dragObject.downY - coords.top;

                startDrag(e); // отобразить начало переноса
            }

            // отобразить перенос объекта при каждом движении мыши
            dragObject.avatar.style.left = e.pageX - dragObject.shiftX + 'px';
            dragObject.avatar.style.top = e.pageY - dragObject.shiftY + 'px';

            return false;
        }

        function onMouseUp(e) {
            if (dragObject.avatar) { // если перенос идет
                finishDrag(e);
            }

            // перенос либо не начинался, либо завершился
            // в любом случае очистим "состояние переноса" dragObject
            dragObject = {};
        }

        function finishDrag(e) {
            var dropElem = findDroppable(e);

            if (!dropElem) {
                self.onDragCancel(dragObject);
            } else {
                self.onDragEnd(dragObject, dropElem);
            }
        }

        function createAvatar(e) {

            // запомнить старые свойства, чтобы вернуться к ним при отмене переноса
            var avatar = dragObject.elem;
            var old = {
                parent: avatar.parentNode,
                nextSibling: avatar.nextSibling,
                position: avatar.position || '',
                left: avatar.left || '',
                top: avatar.top || '',
                zIndex: avatar.zIndex || '',

                width:avatar.width || '',
                height:avatar.height || '',
                background:avatar.background || '',
                cursor:avatar.cursor || '',
            };

            // функция для отмены переноса
            avatar.rollback = function() {
                old.parent.insertBefore(avatar, old.nextSibling);
                avatar.rollbackStyles();
            };

            avatar.rollbackStyles = function() {
                avatar.style.position = old.position;
                avatar.style.left = old.left;
                avatar.style.top = old.top;
                avatar.style.zIndex = old.zIndex;

                avatar.style.width = old.width;
                avatar.style.height = old.height;
                avatar.style.background = old.background;
                avatar.style.cursor = old.cursor;
            };

            avatar.style.width = getComputedStyle(avatar).width;
            avatar.style.height = (parseInt(getComputedStyle(avatar).height.replace("px","")) - 5) + 'px';
            avatar.style.background = 'rgba(255, 230, 230, .9)';
            avatar.style.cursor = 'grabbing';

            return avatar;
        }

        function startDrag(e) {
            var avatar = dragObject.avatar;

            // инициировать начало переноса
            document.body.appendChild(avatar);
            avatar.style.zIndex = 9999;
            avatar.style.position = 'absolute';
        }

        function findDroppable(event) {
            // спрячем переносимый элемент
            dragObject.avatar.hidden = true;

            // получить самый вложенный элемент под курсором мыши
            var elem = document.elementFromPoint(event.clientX, event.clientY);

            // показать переносимый элемент обратно
            dragObject.avatar.hidden = false;

            if (elem == null) {
                // такое возможно, если курсор мыши "вылетел" за границу окна
                return null;
            }

            return elem.closest('.panel-heading');
        }

        document.onmousemove = onMouseMove;
        document.onmouseup = onMouseUp;
        document.onmousedown = onMouseDown;

        this.onDragEnd = function(dragObject, dropElem) {};

        this.onDragCancel = function(dragObject) {};

    };


    function getCoords(elem) { // кроме IE8-
        var box = elem.getBoundingClientRect();

        return {
            top: box.top + pageYOffset,
            left: box.left + pageXOffset
        };

    }


    DragManager.onDragCancel = function(dragObject) {
        dragObject.avatar.rollback();
        console.log('rollback');
    };

    DragManager.onDragEnd = function(dragObject, dropElem) {

        dragObject.avatar.rollbackStyles();

        var id = Number(dragObject.avatar.getAttribute('id').substring(8)),
            parent_id = Number(dropElem.getAttribute('id').substring(8));

        console.log('id = ' + id + ' parent_id = ' + parent_id);

        startPreloader();
        $.post(
            url,
            {
                id: id,
                parent_id: parent_id,
                '_token': token
            },
            function(data) {
                if (data == 'true') {
                    alert('Изменения сохранены. Страница будет перезагружена');
                } else {
                    alert('Ошибка: ' + data);
                }
                location.reload();
                // stopPreloader();
            }
        );

    };

    function addEventPanels(){
        var panels = document.querySelectorAll('.panel-heading');
        for (var i = 0; i < panels.length; i++){

            panels[i].addEventListener('mouseover', function(e){
                e.target.style.background = 'rgba(230, 230, 255, .9)';
            });

            panels[i].addEventListener('mouseout', function(e){
                e.target.style.background = 'rgba(0,0,255, .005)';
            });
        };
    };

    // addEventPanels();


});