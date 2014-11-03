#!/usr/bin/awk -f

#
# usage: curl -s https://api.wordpress.org/secret-key/1.1/salt | awk -f salt_replacer.awk - template
#

FILENAME == "-" {
  salt_lines[cnt++] = $0
}

/{{salts}}/ {
  print salt_lines[1]
  for (i=0; i <= cnt; i++) {
    print salt_lines[i]
  }
  next
}

FILENAME != "-" {
  print
}