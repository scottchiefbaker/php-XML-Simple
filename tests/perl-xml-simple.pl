#!/usr/bin/perl

use strict;
use Data::Dump::Color;
use XML::Simple;
use Getopt::Long;

my $data = $ARGV[0];
my $i    = XMLin($data);

dd($i);
