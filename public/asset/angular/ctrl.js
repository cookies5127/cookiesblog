'use strict';

var ctrl = angular.module('cmsControllers', []);

ctrl
	// 返回前面的浏览地址
	// 记住密码
	// 多用户
	.controller('MainCtrl', ['$scope', 'Api', 'Login', '$state', '$cookieStore',
		function($scope, Api, Login, $state, $cookieStore) {
			showLogin();

			$scope.info = { 'type' : 'info', 'content' : '请输入用户名和密码' };
			$scope.login = function(name, password) {
				Login.attempt(name, password).success(function(data) {
					if ( data.info.status ) {
						showLogin();
						$state.go('admin.dashboard');
						$scope.info = { 'type' : 'info', 'content' : '登陆成功' };
					} else {
						$scope.info = { 'type' : 'danger', 'content' : '请检查您的登陆名和密码' };
					}
				});
			}
			$scope.logout = function() {
				Login.logout().success(function(data) {
					showLogin();
				});;
			}

			Api.get('metas').success(function(data) {
				$scope.metas = data;
			});

			function showLogin() {
				Login.check().success(function(data) {
					if (data.check ) {
						$cookieStore.put('user', data);
						$scope.user = $cookieStore.get('user');
						$scope.test = false;
					} else {
						$scope.test = true;
					}
				});
			}
		}
	])

	.controller('showCtrl', ['$scope', 'Api', '$stateParams',
		function($scope, Api, $stateParams) {
			var id = $stateParams.postid;
			var url = $stateParams.url;

			Api.show(id, url).success(function(data) {
				$scope.data = data;
				$scope.content = marked(data.body);
			});
		}
	])
	.controller('commentCtrl', ['$scope', 'Api', '$stateParams',
		function($scope, Api, $stateParams) {
			var postid = $stateParams.postid;
			showComments(postid);

			$scope.commentSubmit = function() {
				Api.update($scope.comment, postid, 'comments').success(function(data) {
					$scope.comments = data;
				});
			}

			$scope.destroy = function(id) {
				if ( confirm('是否删除改条评论') ) {
					Api.destroy(id, 'comments').success(function(data) {
						showComments(postid);
					});
				}
			}

			function showComments(id) {
				Api.show(id, 'comments').success(function(data) {
					$scope.comments = data;
				});
			}
		}
	])

	.controller('IndexCtrl', ['$scope', 'Api',
		function($scope, Api) {
		}
	])

	// 分页
	.controller('homeCtrl', ['$scope', 'Api', 
		function($scope, Api) {
			Api.get('posts').success(function(data) {
				$scope.posts = data;
			});
		}
	])

	.controller('contactCtrl', ['$scope', 'Api', '$state',
		function($scope, Api, $state) {
			$scope.emailSubmit = function() {
				Api.save($scope.data, 'info').success(function(data) {
					console.log(data);
				});
			}
		}
	])

	.controller('postList', ['$scope', 'Api', '$stateParams',
		function($scope, Api, $stateParams) {
			// 做一个只根据cates的filter
			var cates = $stateParams.cates;

			Api.edit(cates, 'posts').success(function(data) {
				$scope.cates = data[0].name;
				$scope.posts = data;
			});

		}
	])

	.controller('categoryCtrl', ['$scope', 'Api', 
		function($scope, Api) {
			showLists();

			$scope.dataSubmit = function() {
				Api.save($scope.data, 'cates').success(function(data) {
					$scope.data = '';
					showLists();
				});
			}

			function showLists() {
				Api.create('cates').success(function(data) {
					$scope.selects = data;
				});
				Api.get('cates').success(function(data) {
					$scope.lists = data;
				});
			}
		}
	])

	.controller('markdown', ['$scope', 'Api', '$state', '$cookieStore',
		function ($scope, Api, $state, $cookieStore) {
			$scope.info = { show: true };
			$scope.markdown = { body: '' };

			$scope.$watch('markdown.body', function(current) {
				$scope.outputText = marked(current);
			});

			$scope.add = function() {
				$scope.plus = !$scope.plus;
			}

			$scope.save = function(data) {
				Api.save(data, 'notes').success(function(data) {
					$scope.info = { type: 'success', content: '已保存' };
				});
			}

			$scope.show = function(data) {
				Api.save(data, 'notes').success(function(data) {
					$state.go('show', { postid: data, url: 'notes' });
				});
			}

			$scope.noteBook = function(title, id) {
				if (id) {
					var data = { 'title': title, 'c_id': id };
					Api.save(data, 'notes').success(function(data) {
						clickList('seminar', id);
					});
				}
			}

			clickList('top', 0);

			$scope.showList = function(data, id) {
				clickList(data, id);
			}

			function clickList(data, id) {
				Api.update(data, id, 'cates').success(function(data) {
					$scope.lists = data.lists;
					$scope.test = data.test;
					if (data.lists.length == '0') {
						$scope.note = true;
						$scope.notes = data.notes;
					} else {
						$scope.note = false;
					}
				});
			}

			$scope.showNote = function(id) {
				showNote(id);
			}

			var noteid = $cookieStore.get('noteid');
			showNote(noteid);

			function showNote(data) {
				$cookieStore.put('noteid', data);
				Api.show(data, 'notes').success(function(data) {
					$scope.markdown = data;
					$scope.info = { type: 'success', content: data.title };
				});
			}

			$scope.alertToggle = function() {
				$scope.info = { show: true };
			}
		}
	])

	.controller('dashboard', ['$scope', 'Api',
		function($scope, Api) {
			Api.get('books').success(function(data) {
				$scope.books = data;
			});

			Api.get('months').success(function(data) {
				$scope.months = data.lists;
			});

			Api.get('todos').success(function(data) {
				$scope.todos = data.todo;
			});

			Api.get('pros').success(function(data) {
				$scope.projects = data;
			});

			Api.get('frags').success(function(data) {
				$scope.frags = data;
			});

			showSchedule();

			$scope.frag = function(data) {
				Api.save(data, 'frags').success(function(data) {
					$scope.fra = '';
					$scope.frags = data;
				});
			}

			$scope.dropdown = function(data, name) {
				$scope.slug = data;
				$scope.name = name;
			}
			$scope.schedule = function(data, input) {
				if (data == 'summary') {
					Api.update(input, 1, 'schedules').success(function(data) {
						$scope.input = '';
						showSchedule();
					});
				} else {
					var test = { 's_slug' : data, 's_name' : input };
					Api.save(test, 'schedules').success(function(data) {
						$scope.input = '';
						showSchedule();
					});
				}
			}

			function showSchedule() {
				Api.get('schedules').success(function(data) {
					$scope.schedules = data.lists;
				});
			}
		}
	])

	.controller('scheduleCtrl', ['$scope', 'Api',
		function($scope, Api) {
			today();
			$scope.date = '2016-01-';

			$scope.look = function(d) {
				$scope.show = d;
				Api.show(d, 'schedules').success(function(data) {
					$scope.lists = data.lists;
					$scope.summary = data.summary;
				});
			}

			$scope.today = function() {
				today();
			}

			function today() {
				Api.get('schedules').success(function(data) {
					$scope.lists = data.lists;
					$scope.summary = data.summary;
				});
				Api.create('schedules').success(function(data) {
					$scope.show = data;
				});
			}
		}
	])

	// 给时间写过滤器，显示什么时间以前
	// 备忘录可以考虑直接写成待办事务列表，与其他内容连接在一起，生成今日工作内容
	.controller('fragCtrl', ['$scope', 'Api', 
		function($scope, Api) {
			$scope.fragSubmit = function() {
				Api.save($scope.data, 'frags').success(function(data) {
					$scope.data = '';
					$scope.lists = data;
				});
			}
			
			Api.get('frags').success(function(data) {
				$scope.lists = data;
			});
		}
	])

	.controller('monthCtrl', ['$scope', 'Api',
		function($scope, Api) {
			showMonth();
			
			$scope.month = function(id) {
				Api.show(id, 'months').success(function(data) {
					$scope.data = data;
				});
			}

			$scope.monthSubmit = function() {
				Api.save($scope.data, 'months').success(function(data) {
					$scope.data = '';
					showMonth();
				});
			}

			$scope.date = { 'year' : '2016', 'month' : '01' }

			function showMonth() {
				Api.get('months').success(function(data) {
					$scope.months = data;
				});
			}
		}
	])

	.controller('todoCtrl', ['$scope', 'Api',
		function($scope, Api) {
			showTodo();

			$scope.todoSubmit = function() {
				Api.save($scope.todo, 'todos').success(function(data) {
					$scope.todo = '';
					showTodo();
				});
			}

			$scope.edit = function(id) {
				Api.show(id, 'todos').success(function(data) {
					$scope.todo = data;
				});
			}

			function showTodo() {
				Api.get('todos').success(function(data) {
					$scope.lists = data;
				});
			}
		}
	])

	.controller('editorCtrl', ['$scope', 'Api', '$stateParams', '$state',
		function($scope, Api, $stateParams, $state) {
			var url = $stateParams.url;
			var id = $stateParams.id;
			Api.show(id, url).success(function(data) {
				$scope.data = data;
			});

			$scope.count = 0;

			$scope.save = function(data) {
				Api.save(data, url).success(function(data) {
					if (data) {
						$scope.count = $scope.count + 1;
					}
				});
			}

			$scope.clean = function() {
				$scope.data.body = '';
			}
			
			$scope.show = function(data) {
				Api.save(data, url).success(function(data) {
					$state.go('show', {postid:id, url: url});
				});
			}

			$scope.$watch('data.body', function(current) {
				$scope.outputText = marked(current);
			});
		}
	])

	.controller('postCtrl', ['$scope', 'Api',
		function($scope, Api) {
			showPost();

			$scope.postSubmit = function() {
				Api.save($scope.data, 'posts').success(function(data) {
					showPost();
				});
			}

			$scope.destroy = function(id) {
				if ( confirm('是否删除该文章') ) {
					Api.destroy(id, 'posts').success(function(data) {
						showPost();
						console.log(data);
					});
				}
			}

			$scope.restore = function(id) {
				Api.update('', id, 'posts').success(function(data) {
					$scope.lists = data;
				});;
			}

			$scope.showPost = function() {
				$scope.button = !$scope.button;
				showPost();
			}

			$scope.trashPost = function() {
				Api.create('posts').success(function(data) {
					$scope.lists = data;
					$scope.button = !$scope.button;
				});
			}

			function showPost() {
				Api.get('posts').success(function(data) {
					$scope.lists = data;
				});
			}
		}
	])

	.controller('thinkCtrl', ['$scope', 'Api',
		function($scope, Api) {
			getLists();

			$scope.thinkSubmit = function() {
				Api.save($scope.data, 'thinks').success(function(data) {
					$scope.data = '';
					getLists();
				});
			}

			function getLists(){
				Api.get('thinks').success(function(data) {
					$scope.lists = data;
				});
			}
		}
	])
	.controller('thinkShowCtrl', ['$scope', 'Api', '$stateParams',
		function($scope, Api, $stateParams) {
			var tid = $stateParams.tid;
			showWords(tid);

			$scope.wordSubmit = function() {
				Api.update($scope.tword, tid, 'thinks').success(function(data) {
					$scope.tword = '';
					showWords(tid);
				});
			}

			$scope.wordEdit = function(id) {
				Api.edit(id, 'thinks').success(function(data) {
					$scope.tword = data;
				});
			}

			function showWords(id) {
				Api.show(id, 'thinks').success(function(data) {
					$scope.data = data;
				});
			}
		}
	])

	.controller('projectCtrl', ['$scope', 'Api',
		function($scope, Api) {
			showLists();

			$scope.projectSubmit = function() {
				Api.save($scope.project, 'pros').success(function(data) {
					$scope.project = '';
					showLists();
				});
			}

			$scope.changeStatus = function(id) {
				Api.edit(id, 'pros').success(function(data) {
					showLists();
				});
			}

			function showLists() {
				Api.get('pros').success(function(data) {
					$scope.lists = data;
				});
			}
		}
	])
	.controller('projectShowCtrl', ['$scope', 'Api', '$stateParams', 
		function($scope, Api, $stateParams) {
			var pvid = $stateParams.pid + 'x' + $stateParams.vid;
			showPros(pvid);

			Api.update('', pvid, 'pros').success(function(data) {
				$scope.proInput = data;
				$scope.proOutput = data;
			});

			$scope.form = function(data) {
				$scope.proInput = data;
				$scope.proOutput = data;
			}

			$scope.dataSubmit = function() {
				Api.save($scope.project, $scope.proInput).success(function(data) {
					showPros(pvid);
				});
			}
			$scope.wordLook = function(id) {
				Api.show(id, 'prosword').success(function(data) {
					$scope.project['pw_id'] = data.pw_id;
					$scope.project['pw_word'] = data.pw_word;
					$scope.project['pw_content'] = data.pw_content;
				});
			}
			$scope.thinkEdit = function(id) {
				Api.show(id, 'prosthink').success(function(data) {
					$scope.project['pt_id'] = data.pt_id;
					$scope.project['pt_content'] = data.pt_content;
					$scope.project['pt_require'] = data.pt_require;
					$scope.project['pt_check'] = data.pt_check;
					$scope.project['pt_expect'] = data.pt_expect;
				});
			}
			$scope.planLook = function(id) {
				Api.show(id, 'prosplan').success(function(data) {
					$scope.project['pp_id'] = data.pp_id;
					$scope.project['pp_when'] = data.pp_when;
					$scope.project['pp_what'] = data.pp_what;
					$scope.project['pp_cost'] = data.pp_cost;
					$scope.project['pp_fact_cost'] = data.pp_fact_cost;
					$scope.project['pp_log'] = data.pp_log;
				});
			}
			$scope.bugFinish = function(id) {
				alert(id);
				Api.edit(id, 'prosbug').success(function(data) {
					showPros(pvid);
				});
			}
			$scope.checkLook = function(id) {
				Api.show(id, 'proscheck').success(function(data) {
					$scope.project['pc_id'] = data.pc_id;
					$scope.project['pc_question'] = data.pc_question;
					$scope.project['pc_answer'] = data.pc_answer;
				});
			}

			function showPros(id) {
				Api.show(id, 'pros').success(function(data) {
					$scope.project = data;
				});
			}
		}
	])

	.controller('bookCtrl', ['$scope', 'Api', '$stateParams',
		function($scope, Api, $stateParams) {
			showBooks();

			$scope.bookSubmit = function() {
				Api.save($scope.book, 'books').success(function(data) {
					$scope.book = '';
					showBooks();
				});
			}

			function showBooks() {
				Api.get('books').success(function(data) {
					$scope.lists = data;
				});
			}
		}
	])

	.controller('bookShowCtrl', ['$scope', 'Api', '$stateParams', '$state',
		function($scope, Api, $stateParams, $state) {
			var bookid = $stateParams.bookid;
			showBook(bookid);

			$scope.nowSubmit = function() {
				Api.update($scope.book, $scope.book.b_id, 'books').success(function(data) {
				});
			}

			function showBook(id) {
				Api.show(id, 'books').success(function(data) {
					$scope.book = data;
				});
			}
		}
	])

	// 还需要图标
	.controller('AdminCtrl', ['$scope', 'Api',
		function($scope, Api) {
		}
	])
	;
