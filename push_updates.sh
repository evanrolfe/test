#!/bin/bash
ssh evan@evanrolfe.info 'cd ~/evanrolfe.info/yacht_beta;git pull origin;cd ~/evanrolfe.info/yacht_beta_offline;git pull origin;'
echo All Good
