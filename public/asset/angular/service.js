'use strict';

var service = angular.module('cmsServices', ['ngResource']);

service
	.factory('Login', ['$http', 'CSRF_TOKEN', 
		function($http, CSRF_TOKEN) {
			return {
				attempt : function (name, password) {
					return $http({
						method: 'post',
						url: '/auth/login',
						data: { 'token' : CSRF_TOKEN, 'name' : name , 'password' : password },
					});
				},
				logout : function () {
					return $http.get("/auth/logout");
				},
				check : function () {
					return $http.get("/index/create");
				}
			}
		}
	])

	.factory('Api', ['$http', 'CSRF_TOKEN',
		function($http, CSRF_TOKEN) {
			return {
				get : function(url) {
					return $http.get('api/' + url);
				},
				create : function(url) {
					return $http.get('api/' + url + '/create');
				},
				save : function(data, url) {
					return $http({
						method: 'post',
						url: 'api/' + url,
						data: { 'token' : CSRF_TOKEN, 'data' : data },
					});
				},
				show : function(data, url) {
					return $http.get('/api/' + url + '/' + data);
				},
				edit : function(data, url) {
					return $http.get('/api/' + url + '/' + data + '/edit');
				},
				update : function(data, id, url) {
					return $http({
						method: 'patch',
						url: 'api/' + url + '/' + id,
						data: { 'token' : CSRF_TOKEN, 'data' : data },
					});
				},
				destroy : function(data, url) {
					return $http.delete('api/' + url + '/' + data);
				},
			}
		}
	])
	
	;
