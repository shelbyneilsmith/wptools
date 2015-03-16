#!/bin/sh
#
if [[ $1 && ${1} ]] ; then
	project_id=$1
	echo $project_id
	# cd "~/Sites/$project_id/web/"
	alias proj="~/Sites/$project_id/web/"
else
	echo "Project ID not set! Stop wasting my time."
	exit
fi
