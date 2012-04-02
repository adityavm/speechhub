# -*- coding: utf-8 -*-
"""
    Speechhub - A static blog engine
    Copyright (C) 2012  Antonio Ribeiro

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
"""

import os
import sys
import argparse

from functions import create_blog, new_post, new_link, manage, admin, rebuild_blog

USAGE = """Usage:
speechhub <command> [arg,[...]]
commands:
\tcreate-blog
\tadmin
\tmanage
\tnew-post
\tnew-link
\trebuild
        """


def admin_blog(args):
    parser = argparse.ArgumentParser(description='Speechhub is a simple command line static blog engine.')
    parser.add_argument('--username', metavar='username',
                                       type=str, 
                                       nargs='?',
                                       help='User name.',)
    parser.add_argument('--email', metavar='E-mail',
                                       type=str,
                                       nargs='?',
                                       help='User E-mail')
    parser.add_argument('--posts-per-page', metavar='posts-per-page.',
                                            type=int,
                                            nargs=1,
                                            default=5,
                                            help='How many posts by page you want to see.')
    parser.add_argument('--datetime-format', metavar='posts-per-page.',
                                             type=int,
                                             nargs=1,
                                             # default='%D/%M/%A - %h%m%s',
                                             help='Date and time format. Use capitalized for date and not capitalized for time.')
    parser.add_argument('--path', metavar='Speechhub project path.',
                                             type=str,
                                             nargs=1,
                                             help='update the project path.')
    parser.add_argument('--url', metavar='Your blog URL.',
                                             type=str,
                                             nargs=1,
                                             help='update the blog URL.')

    parsed_args = parser.parse_args(args)
    admin(vars(parsed_args))
    

def create_new_blog(args):
    parser = argparse.ArgumentParser(description='Speechhub is a simple command line static blog engine.')
    parser.add_argument('--blog-name', metavar='blog-name',
                                       type=str, 
                                       nargs=1,
                                       required=True,
                                       help='Blog name.')
    parser.add_argument('--path', metavar='path',
                                       type=str, 
                                       nargs='?',
                                       help='Location where the blog will be created.',)
    parser.add_argument('--url', metavar='blog-url',
                                       type=str, 
                                       nargs='?',
                                       help='The URL of your blog.',)
    parser.add_argument('--username', metavar='username',
                                       type=str, 
                                       nargs='?',
                                       help='User name.',)
    parser.add_argument('--email', metavar='E-mail',
                                       type=str,
                                       nargs='?',
                                       help='User E-mail')
    
    parsed_args = parser.parse_args(args)
    create_blog(vars(parsed_args))


def create_new_post(args):
    parser = argparse.ArgumentParser(description='Speechhub is a simple command line static blog engine.')
    parser.add_argument('--title', metavar='title',
                                       type=str,
                                       required=True, 
                                       nargs=1,
                                       help='The title of your post.',)
    parsed_args = parser.parse_args(args)
    new_post(vars(parsed_args))


def create_new_link_post(args):
    parser = argparse.ArgumentParser(description='Speechhub is a simple command line static blog engine.')
    parser.add_argument('--title', metavar='title',
                                       type=str,
                                       required=True, 
                                       nargs=1,
                                       help='The title of your post.',)
    parser.add_argument('--link', metavar='link',
                                       type=str,
                                       required=True, 
                                       nargs=1,
                                       help='The link of your post.',)
    parsed_args = parser.parse_args(args)
    new_link(vars(parsed_args))
    

def manage_blog(args):
    parser = argparse.ArgumentParser(description='Manage your posts.')
    parser.add_argument('--publish-post', metavar='path',
                                       type=str, 
                                       nargs=1,
                                       help='Publish the related post.',)
    parser.add_argument('--unpublish-post', metavar='path',
                                       type=str, 
                                       nargs=1,
                                       help='Unblish the related post.',)
    parser.add_argument('--delete-post', metavar='path',
                                       type=str, 
                                       nargs=1,
                                       help='Delete the related post.',)
    parsed_args = parser.parse_args(args)

    manage(vars(parsed_args))


def main():

    if len(sys.argv) < 2:
        print USAGE
        return

    command = sys.argv[1]
    args = sys.argv[2:]

    if command == 'create-blog':
        create_new_blog(args)
    elif command == 'admin':
        admin_blog(args)
    elif command == 'new-post':
        create_new_post(args)
    elif command == 'new-link':
        create_new_link_post(args)
    elif command == 'manage':
        manage_blog(args)
    elif command == 'rebuild':
        rebuild_blog(args)
    else:
        print USAGE
        return


if __name__=='__main__':
    main()
