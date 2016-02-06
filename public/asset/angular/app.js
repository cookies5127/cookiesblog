'use strict';

var cms = angular.module('cms', [
	'ngCookies',
	'ngSanitize',
	'cmsControllers',
	'cmsFilters',
	'cmsServices',
	'cmsDirectives',
	'ui.router',
    'angularFileUpload',
]);

marked.setOptions({
	renderer: new marked.Renderer(),
	gfm: true,
	tables: true,
	breaks: false,
	pedantic: false,
	sanitize: false,
	smartLists: true,
	smartypants: false,
	highlight: function (code) {
		return hljs.highlightAuto(code).value;
	}
});

cms.constant('CSRF_TOKEN', '{!! csrf_token() !!}');

cms.config(['$stateProvider', '$urlRouterProvider', 
	function($stateProvider, $urlRouterProvider) {
		$urlRouterProvider.when('', '/index/home');

		$stateProvider

			/**
			 *	show: 文章显示页面;
			 *	params: postid, url
			 */
			.state('show', {
				url:			'/show?postid&url',
				templateUrl:	'/template/index/post-show.html',
				data: { pageTitle: '文章' },
			})
			/**
			 *	index: abstract
			 *
			 *	params: info, contact, home, list
			 */
			.state('index', {
				abstract:		true,
				url:			'/index',
				templateUrl:	'/template/index/index.html',
			})
			/**
			 *	home: 页面首页
			 */
			.state('index.home', {
				url:			'/home',
				templateUrl:	'/template/index/home.html',
				data: { pageTitle: '首页' },
			})
			/**
			 *	list: 文章列表
			 */
			.state('index.list', {
				url:			'/list?cates',
				templateUrl:	'/template/index/list.html',
				data: { pageTitle: '文章分类' },
			})
			/**
			 *	login: 登陆页面
			 */
			.state('login', {
				url:			'/login',
				templateUrl:	'/template/index/index-login.html',
				data: { pageTitle: '用户登陆' },
			})
			/**
			 *	info: 个人简历
			 */
			.state('index.info', {
				url:			'/info',
				templateUrl:	'/template/index/info.html',
				data: { pageTitle: '关于我' },
			})
			/**
			 *	contact: 联系我
			 */
			.state('index.contact', {
				url:			'/contact',
				templateUrl:	'/template/index/contact.html',
				data: { pageTitle: '联系我' },
			})
			/**
			 *	markdown: 笔记本
			 */
			.state('markdown', {
				url:			'/markdown',
				templateUrl:	'/template/admin/markdown.html',
				data: { pageTitle: '笔记本' },
			})
			/**
			 *	admin: 后台系统管理
			 *
			 *	function dashboard, post, frag, page, book, lesson, see, wanted, repo
			 */
			.state('admin', {
				abstract:		true,
				url:			'/admin',
				templateUrl:	'/template/admin/admin.html',
			})
			/**
			 * category: 笔记本类目管理
			 */
			.state('admin.category', {
				url:			'/category',
				templateUrl:	'/template/admin/category.html',
				data: { pageTitle: '类目' },
			})
			/**
			 *	dashboard: 后台首页
			 */
			.state('admin.dashboard', {
				url:			'/dashboard',
				templateUrl:	'/template/admin/dashboard.html',
				data: { pageTitle: '仪表盘' },
			})
			/**
			 *	dashboard: 日程查询
			 */
			.state('admin.schedule', {
				url:			'/schedule',
				templateUrl:	'/template/admin/schedule/schedule-admin.html',
				data: { pageTitle: '日程表' },
			})
			/**
			 *	frag: 信息收集
			 */
			.state('admin.frag', {
				url:			'/frag',
				templateUrl:	'/template/admin/frag/frag-admin.html',
				data: { pageTitle: '信息记录' },
			})
			/**
			 *	month: 月工作目标
			 */
			.state('admin.month', {
				url:			'/month',
				templateUrl:	'/template/admin/month/month-admin.html',
				data: { pageTitle: '月计划' },
			})
			/**
			 *	todolist: 待办列表
			 */
			.state('admin.todolist', {
				url:			'/todolist',
				templateUrl:	'/template/admin/todo/todolist.html',
				data: { pageTitle: '待办列表' },
			})
			/**
			 *	editor: post和think的编辑器
			 */
			.state('editor', {
				url:			'/editor?url&id',
				templateUrl:	'/template/admin/editor/editor.html',
			})
			/**
			 *	post: list & form
			 */
			.state('admin.post', {
				url:			'/post',
				templateUrl:	'/template/admin/post/post-admin.html',
				data: { pageTitle: '文章管理' },
			})
			/**
			 *	think: 思考板
			 *	params: list & show
			 */
			.state('admin.think', {
				abstract:		true,
				url:			'/think',
				template:		'<div ui-view> </div>',
			})
			/**
			 *	list: 列表
			 */
			.state('admin.think.list', {
				url:			'/list',
				templateUrl:	'/template/admin/think/think-list.html',
			})
			/**
			 *	show: 关键字列表
			 */
			.state('admin.think.show', {
				url:			'/show?tid',
				templateUrl:	'/template/admin/think/think-show.html',
			})
			/**
			 *	project: 项目列表
			 *	params: list & show
			 */
			.state('admin.project', {
				abstract:		true,
				url:			'/project',
				template:		'<div ui-view> </div>',
			})
			/**
			 *	list: 项目列表
			 */
			.state('admin.project.list', {
				url:			'/list',
				templateUrl:	'/template/admin/project/project-admin.html',
				data: { pageTitle: '项目管理' },
			})
			/**
			 *	show: 项目管理
			 */
			.state('admin.project.show', {
				url:			'/show?pid&vid',
				templateUrl:	'/template/admin/project/project-show.html',
				data: { pageTitle: '项目信息' },
			})

			/**
			 *	book: list & show & question
			 */
			.state('admin.book', {
				abstract:		true,
				url:			'/book',
				template:		'<div ui-view> </div>',
			})
			.state('admin.book.list', {
				url:			'/list',
				templateUrl:	'/template/admin/book/book-list.html',
				data: { pageTitle: '读书管理' },
			})
			.state('admin.book.show', {
				url:			'/show?bookid',
				templateUrl:	'/template/admin/book/book-show.html',
				data: { pageTitle: '书籍详情' },
			})
			/**
			 *	lesson: list & seminar & show
			 */
			.state('admin.lesson', {
				abstract:		true,
				url:			'/lesson',
				template:		'<div ui-view> </div>',
			})
			.state('admin.lesson.list', {
				url:			'/list',
				templateUrl:	'/template/admin/lesson/lesson-admin.html',
				data: { pageTitle: '课程管理' },
			})
			.state('admin.lesson.seminar', {
				url:			'/seminar?seid',
				templateUrl:	'/template/admin/lesson/lesson-seminar.html',
				data: { pageTitle: '专题学习' },
			})
			.state('admin.lesson.show', {
				url:			'/show?lid',
				templateUrl:	'/template/admin/lesson/lesson-show.html',
				data: { pageTitle: '具体信息' },
			})
			/**
			 *	see: list & show
			 */
			.state('admin.see', {
				abstract:		true,
				url:			'/see',
				template:		'<div ui-view> </div>',
			})
			.state('admin.see.list', {
				url:			'/list',
				templateUrl:	'/template/admin/see/see-admin.html',
				data: { pageTitle: '信息管理' },
			})
			.state('admin.see.show', {
				url:			'/show?sid',
				templateUrl:	'/template/admin/see/see-show.html',
				data: { pageTitle: '信息详情' },
			})
			;
	}
]);
