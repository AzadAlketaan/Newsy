import PropTypes from 'prop-types';
// @mui
import { Box, CardActionArea, Card, Link, Typography, Stack } from '@mui/material';
import { styled } from '@mui/material/styles';
// components
import Label from '../../../components/label';
// utils
import { fDate } from '../../../utils/formatTime';

// ----------------------------------------------------------------------

const StyledNewsfeedImg = styled('img')({
  top: 0,
  width: '100%',
  height: '100%',
  objectFit: 'image',
  position: 'absolute',
});

// ----------------------------------------------------------------------

NewsfeedCard.propTypes = {
  newsfeed: PropTypes.object,
};

export default function NewsfeedCard({ newsfeed }) {
  const noImage = '/assets/No_Image_Available.jpg';
  const { image, title, url, source, author, createdAt } = newsfeed;
  
  return (
    <Card>
      <CardActionArea
        component="a"
        href={url}
      >
        <Box sx={{ pt: '100%', position: 'relative' }}>
        {source.name && (
          <Label
            variant="filled"
            color={'info'}
            sx={{
              zIndex: 9,
              top: 16,
              right: 16,
              position: 'absolute',
              textTransform: 'uppercase',
            }}
          >
            {source.name}
          </Label>
        )}
          <StyledNewsfeedImg alt={title} src={image ?? noImage} 
            onError={(e) => {e.target.src = noImage; e.target.onError = null;}}
          />
        </Box>

        <Stack spacing={2} sx={{ p: 3 }}>
          <Link color="inherit" underline="hover">
            <Typography variant="subtitle2" noWrap>
              {title}
            </Typography>
          </Link>

          <Stack direction="row" alignItems="center" justifyContent="space-between">

           <Typography variant="subtitle1">
              &nbsp;
              {author?.name}
            </Typography> 
            <Typography gutterBottom variant="caption" sx={{ color: 'text.disabled', display: 'block' }}>
              {fDate(createdAt)}
            </Typography>
          </Stack>
        </Stack>
      </CardActionArea>
    </Card>
  );
}
