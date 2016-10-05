#!/bin/python2
import commands,os
#Requirments - Python version 2.7
#Place this software in your C drive
commands.getoutput("cd 


entry_points = {

    'console_scripts': [
        
        'my_wonderful_script = my_wonderful_module:my_wonderful_function',
        
     ]

},
print os.system("python setup.py install --home=~/python \
                        --install-purelib=lib \
                        --install-platlib='lib.$PLAT' \
                        --install-scripts=scripts \
                        --install-data=data")
print entry_points
print os.system("python setup.py install")
