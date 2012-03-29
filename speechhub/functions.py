import os
import shutil

import pystache

from statics import path
from exceptions import *


def create_blog(path):
    create_blog_structure(path,{'blog_name':'Ficticional Blog','user_name':'Alan Turing'})


def create_blog_structure(blog_path,blog_config):

    """ Initial blog structure:
        .
        ├── config
        ├── index.html
        ├── pages
        ├── posts
        └── static
            └── css
    """
    slugfied_blog_name = blog_config['slugfied_blog_name']
    os.makedirs(os.path.join(blog_path,slugfied_blog_name))
    os.makedirs(os.path.join(blog_path,os.path.join(slugfied_blog_name,'posts')))
    os.makedirs(os.path.join(blog_path,os.path.join(slugfied_blog_name,'static')))
    os.makedirs(os.path.join(blog_path,os.path.join(slugfied_blog_name,os.path.join('statc','css'))))
    os.makedirs(os.path.join(blog_path,os.path.join(slugfied_blog_name,'pages')))
    os.makedirs(os.path.join(blog_path,os.path.join(slugfied_blog_name,'config')))

    create_empty_index(blog_path,blog_config)


def create_empty_index(blog_path,blog_config):

    index_template = open(path.EMPTY_INDEX_TEMPLATE).read()

    with open(os.path.join(blog_path,'index.html'),'w') as index_file:
        index_content = pystache.render(index_template,blog_config)
        index_file.write(index_content)


def slugify(text, delim=u'-'):
    """Generates an slightly worse ASCII-only slug.
    Originally from:
    http://flask.pocoo.org/snippets/5/
    Generating Slugs
    By Armin Ronacher filed in URLs
    """
    result = []
    for word in _punct_re.split(text.lower()):
        word = normalize('NFKD', word).encode('ascii', 'ignore')
        if word:
            result.append(word)
    return unicode(delim.join(result))