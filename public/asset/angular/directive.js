'use strict';

var dir = angular.module('cmsDirectives',[]);

dir
	.directive("title", ['$rootScope', '$timeout', function($rootScope, $timeout) {
		return {
			link: function() {
				var listener = function(event, toState) {
					$timeout(function() {
						$rootScope.title = (toState.data && toState.data.pageTitle)
						? toState.data.pageTitle : 'Default title';
					});
				};
				$rootScope.$on('$stateChangeSuccess', listener);
			}
		};
	}])

	.directive('autoheight', function() {
		return {
			restrict: 'A',
			link: function (scope, element, attrs) {
				var height = document.documentElement.clientHeight - 39;
				element.context.style.height = height + 'px';
				element.context.style.maxheight = height + 'px';
			}
		}
	})

	.directive('tab', function () {
		return {
			restrict: 'A',
			link: function (scope, element, attrs) {
				element.on('keydown', function (event) {
					var keyCode = event.keyCode || event.which;
					var start = this.selectionStart;
					var point = this.selectionEnd;
					if (keyCode === 9) {
						event.preventDefault();
						element.val(element.val().substring(0, start) 
							+ '\t' + element.val().substring(point));
						this.selectionStart = this.selectionEnd = start + 1;
						element.triggerHandler('change');
					}
					if (keyCode === 13) {
						event.preventDefault();
						var value = element.val(); // 获取输入框中的数据
						var index = value.lastIndexOf('\n', point - 1); // 查看末尾有没有换行符号，返回从光标以前第一个见到位置。

						var s = '', e = '', c = '', sn = false;
						if (index === -1) {
							sn = true; // 是不是第一行
						}

						var x1 = value.substring(index, value.length); // 选取上一行
						
						var rxx = /^\s*/gi,
							c = x1.match(rxx), // 上一句的缩进值
							s = value.substring(0, point), // 光标以前的内容
							e = value.substring(point, value.length); // 光标后面的内容
						
						if (sn) {
							value = s + '\r\n' + c + e;
						} else {
							value = s + c + e;
						}

						element.val(value);
						if (sn) {
							this.setSelectionRange(point + c.length + 1, point + c.length + 1);
						} else {
							this.setSelectionRange(point + c.length, point + c.length);
						}
					}
				});
			}
		}
	})
	
	.directive("fileupload", function (CSRF_TOKEN) {
		return {
			restrict : 'A',
			scope : {
				done: '&', progress: '&'
			},
			link : function (scope, element, attrs) {
				var optionsObj = {
					dataType: 'json'
				};

				if (scope.done) {
					optionsObj.done = function () {
						scope.$apply(function() {
							scope.done({e: e, data: data});
						});
					};
				}

				if (scope.progress) {
					optionsObj.progress = function(e, data) {
						scope.$apply(function() {
							scope.progress({e: e, data: data});
						});
					}
				}

				element.fileupload(optionsObj);
			}
		}
	})

	.directive('ngThumb', ['$window', function($window) {
		var helper = {
			support: !!($window.FileReader && $window.CanvasRenderingContext2D),
			isFile: function(item) {
				return angular.isObject(item) && item instanceof $window.File;
			},
			isImage: function(file) {
				var type =  '|' + file.type.slice(file.type.lastIndexOf('/') + 1) + '|';
				return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
			}
		};

		return {
			restrict: 'A',
			template: '<canvas/>',
			link: function(scope, element, attributes) {
				if (!helper.support) return;

				var params = scope.$eval(attributes.ngThumb);

				if (!helper.isFile(params.file)) return;
				if (!helper.isImage(params.file)) return;

				var canvas = element.find('canvas');
				var reader = new FileReader();

				reader.onload = onLoadFile;
				reader.readAsDataURL(params.file);

				function onLoadFile(event) {
					var img = new Image();
					img.onload = onLoadImage;
					img.src = event.target.result;
				}

				function onLoadImage() {
					var width = params.width || this.width / this.height * params.height;
					var height = params.height || this.height / this.width * params.width;
					canvas.attr({ width: width, height: height });
					canvas[0].getContext('2d').drawImage(this, 0, 0, width, height);
				}
			}
		};
	}]);
